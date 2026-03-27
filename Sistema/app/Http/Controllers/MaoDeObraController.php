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
        $maoDeObras = $usuarioLogado->maoDeObras()->orderBy('custo_diario_hora', 'desc')->paginate(10);

        return view('mao_de_obra.index', compact('maoDeObras'));
    }

    public function create()
    {
        return view('mao_de_obra.create');
    }

    public function store(Request $request)
    {
        $usuarioLogado = Auth::user();
        $dados = $request->all();
        $dados['produtor_id'] = $usuarioLogado->id;

        MaoDeObra::create($dados);

        return redirect()->route('mao-de-obra.index')->with('success', 'Mão de Obra criada com sucesso!');
    }

    public function edit($id)
    {
        $usuarioLogado = Auth::user();
        $maoDeObra = $usuarioLogado->maoDeObras()->findOrFail($id);

        return view('mao_de_obra.edit', compact('maoDeObra'));
    }

    public function update(Request $request, $id)
    {
        $usuarioLogado = Auth::user();
        $dados = $request->all();
        $maoDeObra = $usuarioLogado->maoDeObras()->findOrFail($id);
        
        if (isset($dados['produtor_id'])) {
            unset($dados['produtor_id']);
        }

        $maoDeObra->update($dados);

        return redirect()->route('mao-de-obra.index')->with('success', 'Mão de Obra atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $usuarioLogado = Auth::user();
        $maoDeObra = $usuarioLogado->maoDeObras()->findOrFail($id);

        $maoDeObra->delete();

        return redirect()->route('mao-de-obra.index')->with('success', 'Mão de Obra excluída com sucesso!');
    }
}