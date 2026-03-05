<?php

namespace App\Http\Controllers;

use App\Models\Maquinario;
use App\Models\Produtor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaquinarioController extends Controller
{
    public function index()
    {
        $usuarioLogado = Auth::user();
        $maquinarios = null;

        if ($usuarioLogado->can('is-admin')) {
            $maquinarios = Maquinario::with('produtor')->orderBy('custo_hora', 'desc')->paginate(10);
        }
        else {
            $maquinarios = $usuarioLogado->maquinarios()->orderBy('custo_hora', 'desc')->paginate(10);
        }

        return view('maquinarios.index', compact('maquinarios'));
    }

    public function create()
    {
        $produtores = null;
        if (Auth::user()->can('is-admin')) {
            $produtores = Produtor::all();
        }
        return view('maquinarios.create', compact('produtores'));
    }

    public function store(Request $request)
    {
        $usuarioLogado = Auth::user();
        $dados = $request->all();

        if ($usuarioLogado->can('is-produtor')) {
            $dados['produtor_id'] = $usuarioLogado->id;
        }

        Maquinario::create($dados);

        return redirect()->route('maquinarios.index')->with('success', 'Maquinário criado com sucesso!');
    }

    public function edit($id)
    {
        $usuarioLogado = Auth::user();
        $produtores = null;
        $maquinario = null;

        if ($usuarioLogado->can('is-admin')) {
            $maquinario = Maquinario::findOrFail($id);
            $produtores = Produtor::all();
        }
        else {
            $maquinario = $usuarioLogado->maquinarios()->findOrFail($id);
        }

        return view('maquinarios.edit', compact('maquinario', 'produtores'));
    }

    public function update(Request $request, $id)
    {
        $usuarioLogado = Auth::user();
        $dados = $request->all();
        $maquinario = null;

        if ($usuarioLogado->can('is-admin')) {
            $maquinario = Maquinario::findOrFail($id);
        }
        else {
            $maquinario = $usuarioLogado->maquinarios()->findOrFail($id);
            if (isset($dados['produtor_id'])) {
                unset($dados['produtor_id']);
            }
        }

        $maquinario->update($dados);

        return redirect()->route('maquinarios.index')->with('success', 'Maquinário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $usuarioLogado = Auth::user();
        $maquinario = null;

        if ($usuarioLogado->can('is-admin')) {
            $maquinario = Maquinario::findOrFail($id);
        }
        else {
            $maquinario = $usuarioLogado->maquinarios()->findOrFail($id);
        }

        $maquinario->delete();

        return redirect()->route('maquinarios.index')->with('success', 'Maquinário excluído com sucesso!');
    }
}