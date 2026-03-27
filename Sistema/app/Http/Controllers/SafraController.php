<?php

namespace App\Http\Controllers;

use App\Models\Safra;
use App\Models\Produtor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SafraController extends Controller
{
    public function index()
    {
        $usuarioLogado = Auth::user();
        $safras = $usuarioLogado->safras()->orderBy('data_inicio', 'desc')->paginate(10);

        return view('safras.index', compact('safras'));
    }

    public function create()
    {
        $culturasPredefinidas = ['Soja', 'Milho', 'Trigo', 'Arroz', 'Feijão', 'Cana-de-açúcar', 'Algodão', 'Amendoim', 'Sorgo', 'Café'];
        $culturasNoBanco = Safra::select('cultura')->distinct()->pluck('cultura')->toArray();
        $culturas = array_unique(array_merge($culturasPredefinidas, $culturasNoBanco));
        sort($culturas);

        return view('safras.create', compact('culturas'));
    }

    public function store(Request $request)
    {
        $usuarioLogado = Auth::user();
        $dados = $request->all();
        $dados['produtor_id'] = $usuarioLogado->id;

        Safra::create($dados);

        return redirect()->route('safras.index')->with('success', 'Safra criada com sucesso!');
    }

    public function show($id)
    {
        $usuarioLogado = Auth::user();
        $safra = $usuarioLogado->safras()->findOrFail($id);

        return view('safras.show', compact('safra'));
    }

    public function edit($id)
    {
        $usuarioLogado = Auth::user();
        $safra = $usuarioLogado->safras()->findOrFail($id);

        $culturasPredefinidas = ['Soja', 'Milho', 'Trigo', 'Arroz', 'Feijão', 'Cana-de-açúcar', 'Algodão', 'Amendoim', 'Sorgo', 'Café'];
        $culturasNoBanco = Safra::select('cultura')->distinct()->pluck('cultura')->toArray();
        $culturas = array_unique(array_merge($culturasPredefinidas, $culturasNoBanco));
        sort($culturas);

        return view('safras.edit', compact('safra', 'culturas'));
    }

    public function update(Request $request, $id)
    {
        $usuarioLogado = Auth::user();
        $dados = $request->all();
        $safra = $usuarioLogado->safras()->findOrFail($id);

        if (isset($dados['produtor_id'])) {
            unset($dados['produtor_id']);
        }

        $safra->update($dados);

        return redirect()->route('safras.index')->with('success', 'Safra atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $usuarioLogado = Auth::user();
        $safra = $usuarioLogado->safras()->findOrFail($id);

        $safra->delete();

        return redirect()->route('safras.index')->with('success', 'Safra excluída com sucesso!');
    }
}