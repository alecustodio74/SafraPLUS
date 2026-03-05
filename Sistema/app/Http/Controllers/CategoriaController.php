<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produtor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends Controller
{
    public function index()
    {
        $usuarioLogado = Auth::user();
        $categorias = null;

        if ($usuarioLogado->can('is-admin')) {
            $categorias = Categoria::with('produtor')->orderBy('nome', 'asc')->paginate(10);
        }
        else {
            $categorias = $usuarioLogado->categorias()->orderBy('nome', 'asc')->paginate(10);
        }

        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        $produtores = null;
        if (Auth::user()->can('is-admin')) {
            $produtores = Produtor::all();
        }
        return view('categorias.create', compact('produtores'));
    }

    public function store(Request $request)
    {
        $usuarioLogado = Auth::user();
        $dados = $request->all();

        if ($usuarioLogado->can('is-produtor')) {
            $dados['produtor_id'] = $usuarioLogado->id;
        }

        Categoria::create($dados);

        return redirect()->route('categorias.index')->with('success', 'Categoria criada com sucesso!');
    }

    public function edit($id)
    {
        $usuarioLogado = Auth::user();
        $produtores = null;
        $categoria = null;

        if ($usuarioLogado->can('is-admin')) {
            $categoria = Categoria::findOrFail($id);
            $produtores = Produtor::all();
        }
        else {
            $categoria = $usuarioLogado->categorias()->findOrFail($id);
        }

        return view('categorias.edit', compact('categoria', 'produtores'));
    }

    public function update(Request $request, $id)
    {
        $usuarioLogado = Auth::user();
        $dados = $request->all();
        $categoria = null;

        if ($usuarioLogado->can('is-admin')) {
            $categoria = Categoria::findOrFail($id);
        }
        else {
            $categoria = $usuarioLogado->categorias()->findOrFail($id);
            if (isset($dados['produtor_id'])) {
                unset($dados['produtor_id']);
            }
        }

        $categoria->update($dados);

        return redirect()->route('categorias.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $usuarioLogado = Auth::user();
        $categoria = null;

        if ($usuarioLogado->can('is-admin')) {
            $categoria = Categoria::findOrFail($id);
        }
        else {
            $categoria = $usuarioLogado->categorias()->findOrFail($id);
        }

        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoria excluída com sucesso!');
    }
}