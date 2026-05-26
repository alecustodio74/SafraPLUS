<?php

namespace App\Http\Controllers;

use App\Models\LancamentoFinanceiro;
use App\Models\Safra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $usuarioLogado = Auth::user();
        $receitasTotais = 0;
        $despesasTotais = 0;
        $saldoAtual = 0;
        $safrasRecentes = null;

        $safraIds = $usuarioLogado->safras->pluck('id');

        $receitasTotais = LancamentoFinanceiro::whereIn('safra_id', $safraIds)
            ->where('tipo_receita_custo', 'receita')
            ->sum('valor_total');

        $despesasTotais = LancamentoFinanceiro::whereIn('safra_id', $safraIds)
            ->whereIn('tipo_receita_custo', ['custo', 'despesa'])
            ->sum('valor_total');
            
        $custosOperacionaisTotais = \App\Models\CustoOperacional::whereIn('safra_id', $safraIds)->sum('valor');
        $comprasInsumosTotais = \App\Models\MovimentacaoEstoque::whereIn('insumo_id', $usuarioLogado->insumos->pluck('id'))
            ->where('tipo_movimentacao', 'entrada')
            ->select(DB::raw('SUM(quantidade * valor_unitario) as total'))
            ->value('total');

        $despesasTotais += $custosOperacionaisTotais + ($comprasInsumosTotais ?? 0);

        $safrasRecentes = $usuarioLogado->safras()
            ->orderBy('data_inicio', 'desc')
            ->take(3)->get();

        // Resumo últimos 6 meses (Produtor)
        $seisMesesAtras = Carbon::now()->subMonths(5)->startOfMonth();
        $lancamentosGrafico = LancamentoFinanceiro::whereIn('safra_id', $safraIds)
            ->select(
            DB::raw('DATE_FORMAT(data_lancamento, "%Y-%m") as mes'),
            'tipo_receita_custo',
            DB::raw('SUM(valor_total) as total')
        )
            ->where('data_lancamento', '>=', $seisMesesAtras)
            ->groupBy('mes', 'tipo_receita_custo')
            ->orderBy('mes')
            ->get();

        $custosOperacionaisGrafico = \App\Models\CustoOperacional::whereIn('safra_id', $safraIds)
            ->where('data', '>=', $seisMesesAtras)
            ->select(
                DB::raw('DATE_FORMAT(data, "%Y-%m") as mes'),
                DB::raw('SUM(valor) as total')
            )
            ->groupBy('mes')
            ->get();

        $insumosGrafico = \App\Models\MovimentacaoEstoque::whereIn('insumo_id', $usuarioLogado->insumos->pluck('id'))
            ->where('tipo_movimentacao', 'entrada')
            ->where('data_movimentacao', '>=', $seisMesesAtras)
            ->select(
                DB::raw('DATE_FORMAT(data_movimentacao, "%Y-%m") as mes'),
                DB::raw('SUM(quantidade * valor_unitario) as total')
            )
            ->groupBy('mes')
            ->get();

        $saldoAtual = $receitasTotais - $despesasTotais;

        // Processamento para o Gráfico
        $mesesLabels = collect();
        $dadosReceitas = collect();
        $dadosDespesas = collect();

        for ($i = 5; $i >= 0; $i--) {
            $mesAtual = Carbon::now()->subMonths($i)->format('Y-m');
            $nomeMes = Carbon::now()->subMonths($i)->translatedFormat('M/Y');

            $mesesLabels->push(ucfirst($nomeMes));

            $receitaMes = $lancamentosGrafico->where('mes', $mesAtual)->where('tipo_receita_custo', 'receita')->sum('total');
            $despesaMes = $lancamentosGrafico->where('mes', $mesAtual)->whereIn('tipo_receita_custo', ['custo', 'despesa'])->sum('total');
            $despesaMes += $custosOperacionaisGrafico->where('mes', $mesAtual)->sum('total');
            $despesaMes += $insumosGrafico->where('mes', $mesAtual)->sum('total');

            $dadosReceitas->push($receitaMes);
            $dadosDespesas->push($despesaMes);
        }

        return view('painel', compact('receitasTotais', 'despesasTotais', 'saldoAtual', 'safrasRecentes', 'mesesLabels', 'dadosReceitas', 'dadosDespesas'));
    }

    public function saldoResumo(Request $request)
    {
        $usuarioLogado = Auth::user();
        $safraIds = $usuarioLogado->safras->pluck('id');

        $filtro = $request->input('filtro', 'saldo_atual'); // 'saldo_atual', 'receitas', 'despesas'

        $movimentacoes = collect();

        // 1. Lancamentos Financeiros
        if (in_array($filtro, ['saldo_atual', 'receitas'])) {
            $receitas = LancamentoFinanceiro::whereIn('safra_id', $safraIds)
                ->where('tipo_receita_custo', 'receita')
                ->get()
                ->map(function ($item) {
                    return (object) [
                        'data' => $item->data_lancamento,
                        'descricao' => $item->descricao,
                        'valor' => $item->valor_total,
                        'tipo' => 'receita',
                    ];
                });
            $movimentacoes = $movimentacoes->concat($receitas);
        }

        if (in_array($filtro, ['saldo_atual', 'despesas'])) {
            $despesasLanc = LancamentoFinanceiro::whereIn('safra_id', $safraIds)
                ->whereIn('tipo_receita_custo', ['custo', 'despesa'])
                ->get()
                ->map(function ($item) {
                    return (object) [
                        'data' => $item->data_lancamento,
                        'descricao' => $item->descricao,
                        'valor' => $item->valor_total,
                        'tipo' => 'despesa',
                    ];
                });

            // 2. Custos Operacionais
            $custosOp = \App\Models\CustoOperacional::with(['maoDeObra', 'maquinario'])->whereIn('safra_id', $safraIds)
                ->get()
                ->map(function ($item) {
                    $descParts = [];
                    if ($item->maoDeObra) $descParts[] = $item->maoDeObra->nome_ou_tipo;
                    if ($item->maquinario) $descParts[] = $item->maquinario->nome_modelo;
                    $vinculo = count($descParts) > 0 ? ' (' . implode(' / ', $descParts) . ')' : '';
                    $desc = 'Custo Op: ' . $item->descricao . $vinculo;
                    return (object) [
                        'data' => $item->data,
                        'descricao' => $desc,
                        'valor' => $item->valor,
                        'tipo' => 'despesa',
                    ];
                });

            // 3. Movimentações de Estoque (Compras)
            $comprasInsumos = \App\Models\MovimentacaoEstoque::with('insumo')->whereIn('insumo_id', $usuarioLogado->insumos->pluck('id'))
                ->where('tipo_movimentacao', 'entrada')
                ->get()
                ->map(function ($item) {
                    return (object) [
                        'data' => $item->data_movimentacao,
                        'descricao' => 'Compra Insumo: ' . ($item->insumo->nome ?? 'N/A'),
                        'valor' => $item->quantidade * $item->valor_unitario,
                        'tipo' => 'despesa',
                    ];
                });

            $movimentacoes = $movimentacoes->concat($despesasLanc)->concat($custosOp)->concat($comprasInsumos);
        }

        // Filtros de Data
        $dataInicio = $request->input('data_inicio');
        $dataFim = $request->input('data_fim');
        $mesFiltro = $request->input('mes_filtro');

        if ($dataInicio) {
            $movimentacoes = $movimentacoes->where('data', '>=', $dataInicio);
        }
        if ($dataFim) {
            $movimentacoes = $movimentacoes->where('data', '<=', $dataFim);
        }
        if ($mesFiltro) {
            $movimentacoes = $movimentacoes->filter(function ($item) use ($mesFiltro) {
                return substr($item->data, 0, 7) == $mesFiltro;
            });
        }

        // Sort by date desc
        $movimentacoes = $movimentacoes->sortByDesc('data')->values();

        $totalReceitas = $movimentacoes->where('tipo', 'receita')->sum('valor');
        $totalDespesas = $movimentacoes->where('tipo', 'despesa')->sum('valor');
        $saldo = $totalReceitas - $totalDespesas;

        return view('saldo-resumo', compact('movimentacoes', 'filtro', 'totalReceitas', 'totalDespesas', 'saldo', 'dataInicio', 'dataFim', 'mesFiltro'));
    }
}
