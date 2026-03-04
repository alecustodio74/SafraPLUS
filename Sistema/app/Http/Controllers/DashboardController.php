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

        if ($usuarioLogado->can('is-admin')) {
            $receitasTotais = LancamentoFinanceiro::where('tipo_receita_custo', 'receita')->sum('valor_total');
            $despesasTotais = LancamentoFinanceiro::where('tipo_receita_custo', 'custo')->sum('valor_total');

            $safrasRecentes = Safra::orderBy('data_inicio', 'desc')->take(5)->get();

            // Resumo últimos 6 meses (Admin)
            $seisMesesAtras = Carbon::now()->subMonths(5)->startOfMonth();
            $lancamentosGrafico = LancamentoFinanceiro::select(
                DB::raw('DATE_FORMAT(data, "%Y-%m") as mes'),
                'tipo_receita_custo',
                DB::raw('SUM(valor_total) as total')
            )
                ->where('data', '>=', $seisMesesAtras)
                ->groupBy('mes', 'tipo_receita_custo')
                ->orderBy('mes')
                ->get();

        }
        else {
            $safraIds = $usuarioLogado->safras->pluck('id');

            $receitasTotais = LancamentoFinanceiro::whereIn('safra_id', $safraIds)
                ->where('tipo_receita_custo', 'receita')
                ->sum('valor_total');

            $despesasTotais = LancamentoFinanceiro::whereIn('safra_id', $safraIds)
                ->where('tipo_receita_custo', 'custo')
                ->sum('valor_total');

            $safrasRecentes = $usuarioLogado->safras()
                ->orderBy('data_inicio', 'desc')
                ->take(5)->get();

            // Resumo últimos 6 meses (Produtor)
            $seisMesesAtras = Carbon::now()->subMonths(5)->startOfMonth();
            $lancamentosGrafico = LancamentoFinanceiro::whereIn('safra_id', $safraIds)
                ->select(
                DB::raw('DATE_FORMAT(data, "%Y-%m") as mes'),
                'tipo_receita_custo',
                DB::raw('SUM(valor_total) as total')
            )
                ->where('data', '>=', $seisMesesAtras)
                ->groupBy('mes', 'tipo_receita_custo')
                ->orderBy('mes')
                ->get();
        }

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
            $despesaMes = $lancamentosGrafico->where('mes', $mesAtual)->where('tipo_receita_custo', 'custo')->sum('total');

            $dadosReceitas->push($receitaMes);
            $dadosDespesas->push($despesaMes);
        }

        return view('painel', compact('receitasTotais', 'despesasTotais', 'saldoAtual', 'safrasRecentes', 'mesesLabels', 'dadosReceitas', 'dadosDespesas'));
    }
}
