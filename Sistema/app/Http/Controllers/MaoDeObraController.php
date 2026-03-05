<?php

namespace App\Http\Controllers;

use App\Models\MaoDeObra;
use App\Models\Produtor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaoDeObraController extends Controller
{
    public function index()
    {
        $usuarioLogado = Auth::user();
        $maoDeObras = null;

        if ($usuarioLogado->can('is-admin')) {
            $maoDeObras = MaoDeObra::with('produtor')->orderBy('custo_diario_hora', 'desc')->paginate(10);
        }
        else {
            $maoDeObras = $usuarioLogado->maoDeObras()->orderBy('custo_diario_hora', 'desc')->paginate(10);
        }

        return view('mao_de_obra.index', compact('maoDeObras'));
    }

    public function create()
    {
        $produtores = null;
        if (Auth::user()->can('is-admin')) {
            $produtores = Produtor::all();
        }
        return view('mao_de_obra.create', compact('produtores'));
    }

    public function store(Request $request)
    {
        $usuarioLogado = Auth::user();
        $dados = $request->all();

        if ($usuarioLogado->can('is-produtor')) {
            $dados['produtor_id'] = $usuarioLogado->id;
        }

        MaoDeObra::create($dados);

        return redirect()->route('mao-de-obra.index')->with('success', 'Mão de Obra criada com sucesso!');
    }

    public function edit($id)
    {
        $usuarioLogado = Auth::user();
        $produtores = null;
        $maoDeObra = null;

        if ($usuarioLogado->can('is-admin')) {
            $maoDeObra = MaoDeObra::findOrFail($id);
            $produtores = Produtor::all();
        }
        else {
            $maoDeObra = $usuarioLogado->maoDeObras()->findOrFail($id);
        }

        return view('mao_de_obra.edit', compact('maoDeObra', 'produtores'));
    }

    public function update(Request $request, $id)
    {
        $usuarioLogado = Auth::user();
        $dados = $request->all();
        $maoDeObra = null;

        if ($usuarioLogado->can('is-admin')) {
            $maoDeObra = MaoDeObra::findOrFail($id);
        }
        else {
            $maoDeObra = $usuarioLogado->maoDeObras()->findOrFail($id);
            if (isset($dados['produtor_id'])) {
                unset($dados['produtor_id']);
            }
        }

        $maoDeObra->update($dados);

        return redirect()->route('mao-de-obra.index')->with('success', 'Mão de Obra atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $usuarioLogado = Auth::user();
        $maoDeObra = null;

        if ($usuarioLogado->can('is-admin')) {
            $maoDeObra = MaoDeObra::findOrFail($id);
        }
        else {
            $maoDeObra = $usuarioLogado->maoDeObras()->findOrFail($id);
        }

        $maoDeObra->delete();

        return redirect()->route('mao-de-obra.index')->with('success', 'Mão de Obra excluída com sucesso!');
    }
}