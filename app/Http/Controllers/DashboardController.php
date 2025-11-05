<?php

namespace App\Http\Controllers;

use App\Models\LancamentoFinanceiro;
use App\Models\Safra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        } else {
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
        }

        $saldoAtual = $receitasTotais - $despesasTotais;

        return view('painel', compact('receitasTotais', 'despesasTotais', 'saldoAtual', 'safrasRecentes'));
    }
}
