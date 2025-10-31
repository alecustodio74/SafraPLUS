<?php

namespace App\Http\Controllers;

use App\Models\Produtor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Redirect;

class AdministradorController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $administradores = Produtor::where('role', 'admin')->get();
        return view('administradores.index', compact('administradores'));
    }

    public function create()
    {
        return view('administradores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Produtor::class],
            'password' => ['required', Rules\Password::defaults()],
            'cpf_cnpj' => ['required', 'string', 'max:20', 'unique:'.Produtor::class],
        ]);

        Produtor::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'password' => $request->password,
            'cpf_cnpj' => $request->cpf_cnpj,
            'telefone' => $request->telefone,
            'role' => 'admin',
        ]);

        return Redirect::route('administradores.index')->with('success', 'Administrador criado com sucesso!');
    }

    public function edit(Produtor $administrador)
    {
        return view('administradores.edit', compact('administrador'));
    }

    public function update(Request $request, Produtor $administrador)
    {
        $dados = $request->except(['_token', '_method', 'password', 'role']);

        if ($request->filled('password')) {
            $dados['password'] = $request->password;
        }

        $administrador->update($dados);

        return Redirect::route('administradores.index')->with('success', 'Administrador atualizado com sucesso!');
    }

    public function destroy(Produtor $administrador)
    {
        if (Produtor::where('role', 'admin')->count() === 1) {
             return Redirect::route('administradores.index')->with('error', 'Não é possível excluir o último administrador.');
        }

        $administrador->delete();
        return Redirect::route('administradores.index')->with('success', 'Administrador excluído com sucesso!');
    }
    
}