<?php

namespace App\Http\Controllers;

use App\Models\LancamentoFinanceiro;
use App\Models\Safra;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LancamentoFinanceiroController extends Controller
{
    public function index()
    {
        $usuarioLogado = Auth::user();
        $lancamentos = null;

        if ($usuarioLogado->can('is-admin')) {
            $lancamentos = LancamentoFinanceiro::with('safra', 'categoria')->get();
        } else {
            // Produtor só vê lançamentos das suas safras
            $safraIds = $usuarioLogado->safras->pluck('id');
            $lancamentos = LancamentoFinanceiro::whereIn('safra_id', $safraIds)
                                                 ->with('safra', 'categoria')
                                                 ->get();
        }
        return view('lancamentos_financeiros.index', compact('lancamentos'));
    }

    public function create()
    {
        $usuarioLogado = Auth::user();
        $safras = null;
        
        if ($usuarioLogado->can('is-admin')) {
            $safras = Safra::all();
        } else {
            $safras = $usuarioLogado->safras;
        }
        
        // Categorias são globais, todos podem usar
        $categorias = Categoria::all(); 
        
        return view('lancamentos_financeiros.create', compact('safras', 'categorias'));
    }

    public function store(Request $request)
    {
        $usuarioLogado = Auth::user();
        
        // VALIDAÇÃO ADICIONADA (Este era o problema)
        $dados = $request->validate([
            'safra_id' => 'required|exists:safras,id',
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_receita_custo' => 'required|in:receita,custo',
            'descricao' => 'required|string|max:255',
            'valor_total' => 'required|numeric|min:0',
            'data_lancamento' => 'required|date',
        ]);

        // Verificação de Permissão (Segurança)
        if ($usuarioLogado->can('is-produtor')) {
            // Garante que a safra selecionada pertence ao produtor logado
            $usuarioLogado->safras()->findOrFail($request->safra_id);
        }
        
        LancamentoFinanceiro::create($dados);

        return redirect()->route('lancamentos-financeiros.index')->with('success', 'Lançamento criado com sucesso!');
    }

    public function edit($id)
    {
        $usuarioLogado = Auth::user();
        $lancamento = null;
        $safras = null;
        $categorias = Categoria::all(); // Global

        if ($usuarioLogado->can('is-admin')) {
            $lancamento = LancamentoFinanceiro::findOrFail($id);
            $safras = Safra::all();
        } else {
            $safraIds = $usuarioLogado->safras->pluck('id');
            $lancamento = LancamentoFinanceiro::whereIn('safra_id', $safraIds)->findOrFail($id);
            $safras = $usuarioLogado->safras;
        }

        return view('lancamentos_financeiros.edit', compact('lancamento', 'safras', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $usuarioLogado = Auth::user();
        $lancamento = null;

        if ($usuarioLogado->can('is-admin')) {
            $lancamento = LancamentoFinanceiro::findOrFail($id);
        } else {
            $safraIds = $usuarioLogado->safras->pluck('id');
            $lancamento = LancamentoFinanceiro::whereIn('safra_id', $safraIds)->findOrFail($id);
        }
        
        // VALIDAÇÃO ADICIONADA
        $dados = $request->validate([
            'safra_id' => 'required|exists:safras,id',
            'categoria_id' => 'required|exists:categorias,id',
            'tipo_receita_custo' => 'required|in:receita,custo',
            'descricao' => 'required|string|max:255',
            'valor_total' => 'required|numeric|min:0',
            'data_lancamento' => 'required|date',
        ]);

        $lancamento->update($dados);

        return redirect()->route('lancamentos-financeiros.index')->with('success', 'Lançamento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $usuarioLogado = Auth::user();
        $lancamento = null;

        if ($usuarioLogado->can('is-admin')) {
            $lancamento = LancamentoFinanceiro::findOrFail($id);
        } else {
            $safraIds = $usuarioLogado->safras->pluck('id');
            $lancamento = LancamentoFinanceiro::whereIn('safra_id', $safraIds)->findOrFail($id);
        }
        
        $lancamento->delete();

        return redirect()->route('lancamentos-financeiros.index')->with('success', 'Lançamento excluído com sucesso!');
    }
}