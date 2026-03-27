<?php

namespace App\Http\Controllers;

use App\Models\Safra;
use App\Models\LancamentoFinanceiro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function index()
    {
        $usuarioLogado = Auth::user();
        $safraIds = $usuarioLogado->safras->pluck('id');

        $relatorioLucroPorSafra = Safra::whereIn('id', $safraIds)
            ->withSum(['lancamentosFinanceiros as receitas' => fn($q) => $q->where('tipo_receita_custo', 'receita')], 'valor_total')
            ->withSum(['lancamentosFinanceiros as despesas_financeiras' => fn($q) => $q->whereIn('tipo_receita_custo', ['custo', 'despesa'])], 'valor_total')
            ->withSum('custosOperacionais as despesas_operacionais', 'valor')
            ->orderBy('data_inicio', 'desc')
            ->get()
            ->map(function ($safra) {
            $safra->despesas = ($safra->despesas_financeiras ?? 0) + ($safra->despesas_operacionais ?? 0);
            $safra->lucro = ($safra->receitas ?? 0) - $safra->despesas;
            return $safra;
        });

        $relatorioDistribuicaoCustos = LancamentoFinanceiro::whereIn('safra_id', $safraIds)
            ->whereIn('tipo_receita_custo', ['custo', 'despesa'])
            ->leftJoin('categorias', 'lancamentos_financeiros.categoria_id', '=', 'categorias.id')
            ->select(DB::raw('COALESCE(categorias.nome, "Outros Custos Financeiros") as nome_categoria'), DB::raw('SUM(lancamentos_financeiros.valor_total) as total_custo'))
            ->groupBy('nome_categoria')
            ->get();

        $custosOperacionaisMaquinario = \App\Models\CustoOperacional::whereIn('safra_id', $safraIds)
            ->whereNotNull('maquinario_id')
            ->sum('valor');

        $custosOperacionaisMaoDeObra = \App\Models\CustoOperacional::whereIn('safra_id', $safraIds)
            ->whereNotNull('mao_de_obra_id')
            ->sum('valor');

        $custosOperacionaisOutros = \App\Models\CustoOperacional::whereIn('safra_id', $safraIds)
            ->whereNull('maquinario_id')
            ->whereNull('mao_de_obra_id')
            ->sum('valor');

        $dadosFinaisCustos = $relatorioDistribuicaoCustos->mapWithKeys(function ($item) {
            return [$item->nome_categoria => $item->total_custo];
        })->toArray();

        if ($custosOperacionaisMaquinario > 0) {
            $dadosFinaisCustos['Maquinário'] = ($dadosFinaisCustos['Maquinário'] ?? 0) + $custosOperacionaisMaquinario;
        }
        if ($custosOperacionaisMaoDeObra > 0) {
            $dadosFinaisCustos['Mão de Obra'] = ($dadosFinaisCustos['Mão de Obra'] ?? 0) + $custosOperacionaisMaoDeObra;
        }
        if ($custosOperacionaisOutros > 0) {
            $dadosFinaisCustos['Outros Custos de Operação'] = ($dadosFinaisCustos['Outros Custos de Operação'] ?? 0) + $custosOperacionaisOutros;
        }

        // Ordenar os dados consolidados
        arsort($dadosFinaisCustos);

        $custosLabels = collect(array_keys($dadosFinaisCustos));
        $custosData = collect(array_values($dadosFinaisCustos));

        $totalCustos = collect($dadosFinaisCustos)->sum();
        $totalArea = Safra::whereIn('id', $safraIds)->sum('area_plantada');

        $custoPorHectare = ($totalArea > 0) ? ($totalCustos / $totalArea) : 0;

        $fluxoCaixa = LancamentoFinanceiro::whereIn('safra_id', $safraIds)
            ->select(
            DB::raw('DATE_FORMAT(data_lancamento, "%Y-%m") as mes'),
            DB::raw('SUM(CASE WHEN tipo_receita_custo = "receita" THEN valor_total ELSE 0 END) as total_receitas'),
            DB::raw('SUM(CASE WHEN tipo_receita_custo IN ("custo", "despesa") THEN valor_total ELSE 0 END) as total_despesas')
        )
            ->groupBy('mes')
            ->get()
            ->keyBy('mes')
            ->toArray();

        // Buscar fluxos de custos operacionais
        $fluxoCustosOperacionais = \App\Models\CustoOperacional::whereIn('safra_id', $safraIds)
            ->select(
            DB::raw('DATE_FORMAT(data, "%Y-%m") as mes'),
            DB::raw('SUM(valor) as total_despesas_operacionais')
        )
            ->groupBy('mes')
            ->get();

        // Mesclar os custos operacionais no fluxo de caixa geral
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

        // Ordenar as chaves (meses) em ordem ascendente
        ksort($fluxoCaixa);
        $fluxoCaixaCollection = collect($fluxoCaixa);

        $fluxoLabels = $fluxoCaixaCollection->pluck('mes');
        $fluxoReceitas = $fluxoCaixaCollection->pluck('total_receitas');
        $fluxoDespesas = $fluxoCaixaCollection->pluck('total_despesas');


        return view('relatorios.index', compact(
            'relatorioLucroPorSafra',
            'custosLabels',
            'custosData',
            'custoPorHectare',
            'fluxoLabels',
            'fluxoReceitas',
            'fluxoDespesas'
        ));
    }
}
