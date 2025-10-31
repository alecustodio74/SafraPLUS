<?php

namespace App\Http\Controllers;

use App\Models\Produtor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProdutorController extends Controller
{
    /**
     * Garante que apenas Admins acessem este controller.
     */

    public function index()
    {
        $produtores = Produtor::where('role', 'produtor')->get();
        return view('produtores.index', compact('produtores'));
    }

    public function create()
    {
        return view('produtores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Produtor::class],
            'password' => ['required', Rules\Password::defaults()],
            'cpf_cnpj' => ['required', 'string', 'max:20', 'unique:'.Produtor::class],
            'role' => ['required', 'string', 'in:admin,produtor'],
        ]);

        Produtor::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => $request->password, // Model já faz o hash
            'cpf_cnpj' => $request->cpf_cnpj,
            'propriedade' => $request->propriedade,
            'cultura_principal' => $request->cultura_principal,
            'telefone' => $request->telefone,
            'role' => $request->role,
        ]);

        return redirect()->route('produtores.index')->with('success', 'Produtor criado com sucesso!');
    }

    public function edit(Produtor $produtor)
    {
        return view('produtores.edit', compact('produtor'));
    }

    public function update(Request $request, Produtor $produtor)
    {
        $dados = $request->except(['_token', '_method', 'password']);

        if ($request->filled('password')) {
            $dados['password'] = $request->password; // Model já faz o hash
        }

        $produtor->update($dados);
        
        return redirect()->route('produtores.index')->with('success', 'Produtor atualizado com sucesso!');
    }

    public function destroy(Produtor $produtor)
    {
        $produtor->delete();
        return redirect()->route('produtores.index')->with('success', 'Produtor excluído com sucesso!');
    }
}