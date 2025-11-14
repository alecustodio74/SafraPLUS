<?php

namespace App\Http\Controllers;

use App\Models\MovimentacaoEstoque;
use App\Models\Insumo;
use App\Models\Safra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MovimentacaoEstoqueController extends Controller
{
    public function index()
    {
        $usuarioLogado = Auth::user();
        $movimentacoes = null;

        if ($usuarioLogado->can('is-admin')) {
            $movimentacoes = MovimentacaoEstoque::with('insumo', 'safra')->get();
        } else {
            $insumoIds = $usuarioLogado->insumos->pluck('id');
            $movimentacoes = MovimentacaoEstoque::whereIn('insumo_id', $insumoIds)
                ->with('insumo', 'safra')
                ->get();
        }

        return view('movimentacoes_estoque.index', compact('movimentacoes'));
    }

    public function create()
    {
        $usuarioLogado = Auth::user();
        $insumos = null;
        $safras = null;

        if ($usuarioLogado->can('is-admin')) {
            $insumos = Insumo::all();
            $safras = Safra::all();
        } else {
            $insumos = $usuarioLogado->insumos;
            $safras = $usuarioLogado->safras;
        }

        return view('movimentacoes_estoque.create', compact('insumos', 'safras'));
    }

    public function store(Request $request)
    {
        $usuarioLogado = Auth::user();

        $dados = $request->validate([
            'tipo_movimentacao' => 'required|in:entrada,saida',
            'insumo_id' => 'required|exists:insumos,id',
            'quantidade' => 'required|numeric|min:0.01',
            'valor_unitario' => ['nullable', 'numeric', 'min:0', Rule::requiredIf($request->tipo_movimentacao == 'entrada')],
            'safra_id' => ['nullable', 'exists:safras,id', Rule::requiredIf($request->tipo_movimentacao == 'saida')],
            'data_movimentacao' => 'required|date',
        ]);

        $insumo = Insumo::findOrFail($dados['insumo_id']);

        if ($usuarioLogado->can('is-produtor')) {
            if ($insumo->produtor_id != $usuarioLogado->id) {
                abort(403, 'Este insumo não pertence a você.');
            }
            if ($request->filled('safra_id')) {
                $usuarioLogado->safras()->findOrFail($request->safra_id);
            }
        }

        if ($dados['tipo_movimentacao'] == 'entrada') {
            $insumo->estoque_atual += $dados['quantidade'];
        } else {
            if ($insumo->estoque_atual < $dados['quantidade']) {
                return back()->with('error', 'Estoque insuficiente para esta saída.')->withInput();
            }
            $insumo->estoque_atual -= $dados['quantidade'];
        }

        $insumo->save();
        MovimentacaoEstoque::create($dados);

        return redirect()->route('movimentacoes-estoque.index')->with('success', 'Movimentação criada com sucesso!');
    }

    public function edit($id)
    {
        $usuarioLogado = Auth::user();
        $movimentacao = null;
        $insumos = null;
        $safras = null;

        if ($usuarioLogado->can('is-admin')) {
            $movimentacao = MovimentacaoEstoque::findOrFail($id);
            $insumos = Insumo::all();
            $safras = Safra::all();
        } else {
            $insumoIds = $usuarioLogado->insumos->pluck('id');
            $movimentacao = MovimentacaoEstoque::whereIn('insumo_id', $insumoIds)->findOrFail($id);
            $insumos = $usuarioLogado->insumos;
            $safras = $usuarioLogado->safras;
        }

        return view('movimentacoes_estoque.edit', compact('movimentacao', 'insumos', 'safras'));
    }

    public function update(Request $request, $id)
    {
        $usuarioLogado = Auth::user();
        $movimentacao = null;

        if ($usuarioLogado->can('is-admin')) {
            $movimentacao = MovimentacaoEstoque::findOrFail($id);
        } else {
            $insumoIds = $usuarioLogado->insumos->pluck('id');
            $movimentacao = MovimentacaoEstoque::whereIn('insumo_id', $insumoIds)->findOrFail($id);
        }

        $dados = $request->validate([
            'tipo_movimentacao' => 'required|in:entrada,saida',
            'insumo_id' => 'required|exists:insumos,id',
            'quantidade' => 'required|numeric|min:0.01',
            'valor_unitario' => ['nullable', 'numeric', 'min:0', Rule::requiredIf($request->tipo_movimentacao == 'entrada')],
            'safra_id' => ['nullable', 'exists:safras,id', Rule::requiredIf($request->tipo_movimentacao == 'saida')],
            'data_movimentacao' => 'required|date',
        ]);

        $movimentacao->update($dados);

        return redirect()->route('movimentacoes-estoque.index')->with('success', 'Movimentação atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $usuarioLogado = Auth::user();
        $movimentacao = null;

        if ($usuarioLogado->can('is-admin')) {
            $movimentacao = MovimentacaoEstoque::findOrFail($id);
        } else {
            $insumoIds = $usuarioLogado->insumos->pluck('id');
            $movimentacao = MovimentacaoEstoque::whereIn('insumo_id', $insumoIds)->findOrFail($id);
        }

        $insumo = $movimentacao->insumo;
        if ($movimentacao->tipo_movimentacao == 'entrada') {
            $insumo->estoque_atual -= $movimentacao->quantidade;
        } else {
            $insumo->estoque_atual += $movimentacao->quantidade;
        }
        $insumo->save();

        $movimentacao->delete();

        return redirect()->route('movimentacoes-estoque.index')->with('success', 'Movimentação excluída e estoque revertido!');
    }
}
