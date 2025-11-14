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
        $safraIds = null;

        if ($usuarioLogado->can('is-admin')) {
            $safraIds = Safra::pluck('id');
        } else {
            $safraIds = $usuarioLogado->safras->pluck('id');
        }

        $relatorioLucroPorSafra = Safra::whereIn('id', $safraIds)
            ->withSum(['lancamentosFinanceiros as receitas' => fn($q) => $q->where('tipo_receita_custo', 'receita')], 'valor_total')
            ->withSum(['lancamentosFinanceiros as despesas' => fn($q) => $q->where('tipo_receita_custo', 'custo')], 'valor_total')
            ->get()
            ->map(function ($safra) {
                $safra->lucro = $safra->receitas - $safra->despesas;
                return $safra;
            });

        $relatorioDistribuicaoCustos = LancamentoFinanceiro::whereIn('safra_id', $safraIds)
            ->where('tipo_receita_custo', 'custo')
            ->join('categorias', 'lancamentos_financeiros.categoria_id', '=', 'categorias.id')
            ->select('categorias.nome', DB::raw('SUM(lancamentos_financeiros.valor_total) as total_custo'))
            ->groupBy('categorias.nome')
            ->orderBy('total_custo', 'desc')
            ->get();

        $custosLabels = $relatorioDistribuicaoCustos->pluck('nome');
        $custosData = $relatorioDistribuicaoCustos->pluck('total_custo');

        $totalCustos = $relatorioDistribuicaoCustos->sum('total_custo');
        $totalArea = Safra::whereIn('id', $safraIds)->sum('area_plantada');

        $custoPorHectare = ($totalArea > 0) ? ($totalCustos / $totalArea) : 0;

        $fluxoCaixa = LancamentoFinanceiro::whereIn('safra_id', $safraIds)
            ->select(
                DB::raw('DATE_FORMAT(data_lancamento, "%Y-%m") as mes'),
                DB::raw('SUM(CASE WHEN tipo_receita_custo = "receita" THEN valor_total ELSE 0 END) as total_receitas'),
                DB::raw('SUM(CASE WHEN tipo_receita_custo = "custo" THEN valor_total ELSE 0 END) as total_despesas')
            )
            ->groupBy('mes')
            ->orderBy('mes', 'asc')
            ->get();

        $fluxoLabels = $fluxoCaixa->pluck('mes');
        $fluxoReceitas = $fluxoCaixa->pluck('total_receitas');
        $fluxoDespesas = $fluxoCaixa->pluck('total_despesas');


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
