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
        $insumos = null;

        if ($usuarioLogado->can('is-admin')) {
            $insumos = Insumo::with('produtor')->get();
        } else {
            $insumos = $usuarioLogado->insumos;
        }

        return view('insumos.index', compact('insumos'));
    }

    public function create()
    {
        $produtores = null;
        if (Auth::user()->can('is-admin')) {
            $produtores = Produtor::all();
        }
        return view('insumos.create', compact('produtores'));
    }

    public function store(Request $request)
    {
        $usuarioLogado = Auth::user();
        $dados = $request->all();

        if ($usuarioLogado->can('is-produtor')) {
            $dados['produtor_id'] = $usuarioLogado->id;
        }
        
        Insumo::create($dados);

        return redirect()->route('insumos.index')->with('success', 'Insumo criado com sucesso!');
    }

    public function edit($id)
    {
        $usuarioLogado = Auth::user();
        $produtores = null;
        $insumo = null;

        if ($usuarioLogado->can('is-admin')) {
            $insumo = Insumo::findOrFail($id);
            $produtores = Produtor::all();
        } else {
            $insumo = $usuarioLogado->insumos()->findOrFail($id);
        }

        return view('insumos.edit', compact('insumo', 'produtores'));
    }

    public function update(Request $request, $id)
    {
        $usuarioLogado = Auth::user();
        $dados = $request->all();
        $insumo = null;

        if ($usuarioLogado->can('is-admin')) {
            $insumo = Insumo::findOrFail($id);
        } else {
            $insumo = $usuarioLogado->insumos()->findOrFail($id);
            if (isset($dados['produtor_id'])) {
                unset($dados['produtor_id']);
            }
        }

        $insumo->update($dados);

        return redirect()->route('insumos.index')->with('success', 'Insumo atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $usuarioLogado = Auth::user();
        $insumo = null;

        if ($usuarioLogado->can('is-admin')) {
            $insumo = Insumo::findOrFail($id);
        } else {
            $insumo = $usuarioLogado->insumos()->findOrFail($id);
        }
        
        $insumo->delete();

        return redirect()->route('insumos.index')->with('success', 'Insumo excluído com sucesso!');
    }
}