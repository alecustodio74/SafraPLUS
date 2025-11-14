<?php

namespace App\Http\Controllers;

use App\Models\CustoOperacional;
use App\Models\Safra;
use App\Models\Maquinario;
use App\Models\MaoDeObra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustoOperacionalController extends Controller
{
    public function index()
    {
        $usuarioLogado = Auth::user();
        $custos = null;

        if ($usuarioLogado->can('is-admin')) {
            $custos = CustoOperacional::with('safra', 'maquinario', 'maoDeObra')->get();
        } else {
            $safraIds = $usuarioLogado->safras->pluck('id');
            $custos = CustoOperacional::whereIn('safra_id', $safraIds)
                ->with('safra', 'maquinario', 'maoDeObra')
                ->get();
        }

        return view('custos_operacionais.index', compact('custos'));
    }

    public function create()
    {
        $usuarioLogado = Auth::user();
        $safras = null;
        $maquinarios = null;
        $maoDeObras = null;

        if ($usuarioLogado->can('is-admin')) {
            $safras = Safra::all();
            $maquinarios = Maquinario::all();
            $maoDeObras = MaoDeObra::all();
        } else {
            $safras = $usuarioLogado->safras;
            $maquinarios = $usuarioLogado->maquinarios;
            $maoDeObras = $usuarioLogado->maoDeObras;
        }

        return view('custos_operacionais.create', compact('safras', 'maquinarios', 'maoDeObras'));
    }

    public function store(Request $request)
    {
        $usuarioLogado = Auth::user();

        $dados = $request->validate([
            'safra_id' => 'required|exists:safras,id',
            'descricao' => 'required|string|max:255',
            'data' => 'required|date',
            'valor' => 'required|numeric|min:0',
            'maquinario_id' => 'nullable|exists:maquinarios,id',
            'mao_de_obra_id' => 'nullable|exists:mao_de_obra,id',
        ]);

        if ($usuarioLogado->can('is-produtor')) {
            $usuarioLogado->safras()->findOrFail($request->safra_id);
        }

        CustoOperacional::create($dados);

        return redirect()->route('custos-operacionais.index')->with('success', 'Custo operacional criado com sucesso!');
    }

    public function edit($id)
    {
        $usuarioLogado = Auth::user();
        $custo = null;
        $safras = null;
        $maquinarios = null;
        $maoDeObras = null;

        if ($usuarioLogado->can('is-admin')) {
            $custo = CustoOperacional::findOrFail($id);
            $safras = Safra::all();
            $maquinarios = Maquinario::all();
            $maoDeObras = MaoDeObra::all();
        } else {
            $safraIds = $usuarioLogado->safras->pluck('id');
            $custo = CustoOperacional::whereIn('safra_id', $safraIds)->findOrFail($id);

            $safras = $usuarioLogado->safras;
            $maquinarios = $usuarioLogado->maquinarios;
            $maoDeObras = $usuarioLogado->maoDeObras;
        }

        return view('custos_operacionais.edit', compact('custo', 'safras', 'maquinarios', 'maoDeObras'));
    }

    public function update(Request $request, $id)
    {
        $usuarioLogado = Auth::user();
        $custo = null;

        if ($usuarioLogado->can('is-admin')) {
            $custo = CustoOperacional::findOrFail($id);
        } else {
            $safraIds = $usuarioLogado->safras->pluck('id');
            $custo = CustoOperacional::whereIn('safra_id', $safraIds)->findOrFail($id);
        }

        $dados = $request->validate([
            'safra_id' => 'required|exists:safras,id',
            'descricao' => 'required|string|max:255',
            'data' => 'required|date',
            'valor' => 'required|numeric|min:0',
            'maquinario_id' => 'nullable|exists:maquinarios,id',
            'mao_de_obra_id' => 'nullable|exists:mao_de_obra,id',
        ]);

        $custo->update($dados);

        return redirect()->route('custos-operacionais.index')->with('success', 'Custo operacional atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $usuarioLogado = Auth::user();
        $custo = null;

        if ($usuarioLogado->can('is-admin')) {
            $custo = CustoOperacional::findOrFail($id);
        } else {
            $safraIds = $usuarioLogado->safras->pluck('id');
            $custo = CustoOperacional::whereIn('safra_id', $safraIds)->findOrFail($id);
        }

        $custo->delete();

        return redirect()->route('custos-operacionais.index')->with('success', 'Custo operacional excluído com sucesso!');
    }
}
