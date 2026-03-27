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
        $categorias = $usuarioLogado->categorias()->orderBy('nome', 'asc')->paginate(10);

        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $usuarioLogado = Auth::user();
        $dados = $request->all();
        $dados['produtor_id'] = $usuarioLogado->id;

        Categoria::create($dados);

        return redirect()->route('categorias.index')->with('success', 'Categoria criada com sucesso!');
    }

    public function edit($id)
    {
        $usuarioLogado = Auth::user();
        $categoria = $usuarioLogado->categorias()->findOrFail($id);

        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $usuarioLogado = Auth::user();
        $dados = $request->all();
        $categoria = $usuarioLogado->categorias()->findOrFail($id);
        
        if (isset($dados['produtor_id'])) {
            unset($dados['produtor_id']);
        }

        $categoria->update($dados);

        return redirect()->route('categorias.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $usuarioLogado = Auth::user();
        $categoria = $usuarioLogado->categorias()->findOrFail($id);

        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoria excluída com sucesso!');
    }
}