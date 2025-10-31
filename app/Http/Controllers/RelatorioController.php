<?php

namespace App\Http\Controllers;

use App\Models\Safra;
use App\Models\LancamentoFinanceiro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    /**
     * Mostra a página principal de relatórios.
     */
    public function index()
    {
        $usuarioLogado = Auth::user();
        $relatorioLucroPorSafra = null;
        $relatorioDistribuicaoCustos = null;

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

        return view('relatorios.index', compact('relatorioLucroPorSafra', 'relatorioDistribuicaoCustos'));
    }
}