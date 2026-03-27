<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Models\Produtor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsumoController extends Controller
{
    public function index()
    {
        $usuarioLogado = Auth::user();
        $insumos = $usuarioLogado->insumos()->orderBy('estoque_atual', 'asc')->paginate(10);

        return view('insumos.index', compact('insumos'));
    }

    public function create()
    {
        return view('insumos.create');
    }

    public function store(Request $request)
    {
        $usuarioLogado = Auth::user();
        $dados = $request->all();
        $dados['produtor_id'] = $usuarioLogado->id;

        Insumo::create($dados);

        return redirect()->route('insumos.index')->with('success', 'Insumo criado com sucesso!');
    }

    public function edit($id)
    {
        $usuarioLogado = Auth::user();
        $insumo = $usuarioLogado->insumos()->findOrFail($id);

        return view('insumos.edit', compact('insumo'));
    }

    public function update(Request $request, $id)
    {
        $usuarioLogado = Auth::user();
        $dados = $request->all();
        $insumo = $usuarioLogado->insumos()->findOrFail($id);
        
        if (isset($dados['produtor_id'])) {
            unset($dados['produtor_id']);
        }

        $insumo->update($dados);

        return redirect()->route('insumos.index')->with('success', 'Insumo atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $usuarioLogado = Auth::user();
        $insumo = $usuarioLogado->insumos()->findOrFail($id);

        $insumo->delete();

        return redirect()->route('insumos.index')->with('success', 'Insumo excluído com sucesso!');
    }
}