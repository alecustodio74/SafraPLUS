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
        $maquinarios = $usuarioLogado->maquinarios()->orderBy('custo_hora', 'desc')->paginate(10);

        return view('maquinarios.index', compact('maquinarios'));
    }

    public function create()
    {
        return view('maquinarios.create');
    }

    public function store(Request $request)
    {
        $usuarioLogado = Auth::user();
        $dados = $request->all();
        $dados['produtor_id'] = $usuarioLogado->id;

        Maquinario::create($dados);

        return redirect()->route('maquinarios.index')->with('success', 'Maquinário criado com sucesso!');
    }

    public function edit($id)
    {
        $usuarioLogado = Auth::user();
        $maquinario = $usuarioLogado->maquinarios()->findOrFail($id);

        return view('maquinarios.edit', compact('maquinario'));
    }

    public function update(Request $request, $id)
    {
        $usuarioLogado = Auth::user();
        $dados = $request->all();
        $maquinario = $usuarioLogado->maquinarios()->findOrFail($id);
        
        if (isset($dados['produtor_id'])) {
            unset($dados['produtor_id']);
        }

        $maquinario->update($dados);

        return redirect()->route('maquinarios.index')->with('success', 'Maquinário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $usuarioLogado = Auth::user();
        $maquinario = $usuarioLogado->maquinarios()->findOrFail($id);

        $maquinario->delete();

        return redirect()->route('maquinarios.index')->with('success', 'Maquinário excluído com sucesso!');
    }
}