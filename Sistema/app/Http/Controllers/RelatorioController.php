<?php

namespace App\Http\Controllers;

use App\Models\Safra;
use App\Models\LancamentoFinanceiro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function index(Request $request)
    {
        $usuarioLogado = Auth::user();
        
        $filtroSafra = $request->input('safra_id');
        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');

        if ($filtroSafra) {
            $safraIds = $usuarioLogado->safras()->where('id', $filtroSafra)->pluck('id');
        } else {
            $safraIds = $usuarioLogado->safras->pluck('id');
        }

        $relatorioLucroPorSafra = Safra::whereIn('id', $safraIds)
            ->withSum(['lancamentosFinanceiros as receitas' => fn($q) => $q->where('tipo_receita_custo', 'receita')], 'valor_total')
            ->withSum(['lancamentosFinanceiros as despesas_financeiras' => fn($q) => $q->whereIn('tipo_receita_custo', ['custo', 'despesa'])], 'valor_total')
            ->withSum('custosOperacionais as despesas_operacionais', 'valor')
            ->orderBy('data_inicio', 'desc')
            ->get()
            ->map(function ($safra) {
            $despesas_insumos = \App\Models\MovimentacaoEstoque::where('safra_id', $safra->id)->where('tipo_movimentacao', 'saida')->select(DB::raw('SUM(quantidade * valor_unitario) as total'))->value('total');
            $safra->despesas_insumos = $despesas_insumos ?? 0;
            $safra->despesas = ($safra->despesas_financeiras ?? 0) + ($safra->despesas_operacionais ?? 0) + $safra->despesas_insumos;
            $safra->lucro = ($safra->receitas ?? 0) - $safra->despesas;
            return $safra;
        });

        $queryDistribuicao = LancamentoFinanceiro::whereIn('safra_id', $safraIds)->whereIn('tipo_receita_custo', ['custo', 'despesa']);
        if ($dataInicio) $queryDistribuicao->where('data_lancamento', '>=', $dataInicio);
        if ($dataFim) $queryDistribuicao->where('data_lancamento', '<=', $dataFim);
        
        $relatorioDistribuicaoCustos = $queryDistribuicao->leftJoin('categorias', 'lancamentos_financeiros.categoria_id', '=', 'categorias.id')
            ->select(DB::raw('COALESCE(categorias.nome, "Outros Custos Financeiros") as nome_categoria'), DB::raw('SUM(lancamentos_financeiros.valor_total) as total_custo'))
            ->groupBy('nome_categoria')
            ->get();

        $dadosFinaisCustos = $relatorioDistribuicaoCustos->mapWithKeys(function ($item) {
            return [$item->nome_categoria => $item->total_custo];
        })->toArray();

        $queryCustosOp = \App\Models\CustoOperacional::with(['maquinario', 'maoDeObra'])
            ->whereIn('safra_id', $safraIds);
        if ($dataInicio) $queryCustosOp->where('data', '>=', $dataInicio);
        if ($dataFim) $queryCustosOp->where('data', '<=', $dataFim);

        $custosOperacionais = $queryCustosOp->get();

        foreach ($custosOperacionais as $custo) {
            $vinculos = [];
            if ($custo->maquinario_id && $custo->maquinario) {
                $vinculos[] = $custo->maquinario->nome_modelo;
            }
            if ($custo->mao_de_obra_id && $custo->maoDeObra) {
                $vinculos[] = $custo->maoDeObra->nome_ou_tipo;
            }
            
            $label = $custo->descricao ?: 'Custo Operacional';
            if (count($vinculos) > 0) {
                $label .= ' (' . implode(' + ', $vinculos) . ')';
            }

            $dadosFinaisCustos[$label] = ($dadosFinaisCustos[$label] ?? 0) + $custo->valor;
        }

        $queryInsumos = \App\Models\MovimentacaoEstoque::whereIn('safra_id', $safraIds)->where('tipo_movimentacao', 'saida');
        if ($dataInicio) $queryInsumos->where('data_movimentacao', '>=', $dataInicio);
        if ($dataFim) $queryInsumos->where('data_movimentacao', '<=', $dataFim);
        $custoInsumos = $queryInsumos->select(DB::raw('SUM(quantidade * valor_unitario) as total'))->value('total');

        if ($custoInsumos > 0) {
            $dadosFinaisCustos['Insumos'] = ($dadosFinaisCustos['Insumos'] ?? 0) + $custoInsumos;
        }

        // Ordenar os dados consolidados
        arsort($dadosFinaisCustos);

        $custosLabels = collect(array_keys($dadosFinaisCustos));
        $custosData = collect(array_values($dadosFinaisCustos));

        $totalCustos = collect($dadosFinaisCustos)->sum();
        $totalArea = Safra::whereIn('id', $safraIds)->sum('area_plantada');

        $custoPorHectare = ($totalArea > 0) ? ($totalCustos / $totalArea) : 0;

        $queryFluxo = LancamentoFinanceiro::whereIn('safra_id', $safraIds);
        if ($dataInicio) $queryFluxo->where('data_lancamento', '>=', $dataInicio);
        if ($dataFim) $queryFluxo->where('data_lancamento', '<=', $dataFim);

        $fluxoCaixa = $queryFluxo->select(
            DB::raw('DATE_FORMAT(data_lancamento, "%Y-%m") as mes'),
            DB::raw('SUM(CASE WHEN tipo_receita_custo = "receita" THEN valor_total ELSE 0 END) as total_receitas'),
            DB::raw('SUM(CASE WHEN tipo_receita_custo IN ("custo", "despesa") THEN valor_total ELSE 0 END) as total_despesas')
        )
            ->groupBy('mes')
            ->get()
            ->keyBy('mes')
            ->toArray();

        // Buscar fluxos de custos operacionais
        $queryFluxoOp = \App\Models\CustoOperacional::whereIn('safra_id', $safraIds);
        if ($dataInicio) $queryFluxoOp->where('data', '>=', $dataInicio);
        if ($dataFim) $queryFluxoOp->where('data', '<=', $dataFim);

        $fluxoCustosOperacionais = $queryFluxoOp->select(
            DB::raw('DATE_FORMAT(data, "%Y-%m") as mes'),
            DB::raw('SUM(valor) as total_despesas_operacionais')
        )
            ->groupBy('mes')
            ->get();

        foreach ($fluxoCustosOperacionais as $custoOp) {
            $mes = $custoOp->mes;
            if (!isset($fluxoCaixa[$mes])) {
                $fluxoCaixa[$mes] = [
                    'mes' => $mes,
                    'total_receitas' => 0,
                    'total_despesas' => 0,
                ];
            }
            $fluxoCaixa[$mes]['total_despesas'] += $custoOp->total_despesas_operacionais;
        }

        if ($filtroSafra) {
            // Buscar fluxos de usos de insumos para a safra específica
            $queryFluxoIns = \App\Models\MovimentacaoEstoque::whereIn('safra_id', $safraIds)->where('tipo_movimentacao', 'saida');
        } else {
            // Buscar compras globais de insumos
            $insumoIds = $usuarioLogado->insumos->pluck('id');
            $queryFluxoIns = \App\Models\MovimentacaoEstoque::whereIn('insumo_id', $insumoIds)->where('tipo_movimentacao', 'entrada');
        }
        
        if ($dataInicio) $queryFluxoIns->where('data_movimentacao', '>=', $dataInicio);
        if ($dataFim) $queryFluxoIns->where('data_movimentacao', '<=', $dataFim);

        $fluxoInsumos = $queryFluxoIns->select(
                DB::raw('DATE_FORMAT(data_movimentacao, "%Y-%m") as mes'),
                DB::raw('SUM(quantidade * valor_unitario) as total_usos')
            )
            ->groupBy('mes')
            ->get();

        foreach ($fluxoInsumos as $uso) {
            $mes = $uso->mes;
            if (!isset($fluxoCaixa[$mes])) {
                $fluxoCaixa[$mes] = [
                    'mes' => $mes,
                    'total_receitas' => 0,
                    'total_despesas' => 0,
                ];
            }
            $fluxoCaixa[$mes]['total_despesas'] += $uso->total_usos;
        }

        ksort($fluxoCaixa);
        $fluxoCaixaCollection = collect($fluxoCaixa);

        $fluxoLabels = $fluxoCaixaCollection->pluck('mes');
        $fluxoReceitas = $fluxoCaixaCollection->pluck('total_receitas');
        $fluxoDespesas = $fluxoCaixaCollection->pluck('total_despesas');

        $safrasList = $usuarioLogado->safras;

        return view('relatorios.index', compact(
            'relatorioLucroPorSafra',
            'custosLabels',
            'custosData',
            'custoPorHectare',
            'fluxoLabels',
            'fluxoReceitas',
            'fluxoDespesas',
            'safrasList',
            'filtroSafra',
            'dataInicio',
            'dataFim'
        ));
    }
}
