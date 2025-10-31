<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    /**
     * Mostra o formulário de edição de perfil.
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }


    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:produtores,email,'.$user->id], 
            'cpf_cnpj' => ['required', 'string', 'max:20', 'unique:produtores,cpf_cnpj,'.$user->id],
            'telefone' => ['nullable', 'string', 'max:20'],
            'propriedade' => ['nullable', 'string', 'max:255'],
            'cultura_principal' => ['nullable', 'string', 'max:100'],
        ]);

        $user->update($request->all());

        return Redirect::route('profile.edit')->with('success', 'Perfil atualizado com sucesso!');
    }
    

    public function editPassword(Request $request)
    {
        return view('profile.edit-password'); 
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'current_password' => ['required', 'current_password'], 
            'password' => ['required', Rules\Password::defaults(), 'confirmed'], 
        ]);

        $user->update([
            'password' => $request->password,
        ]);

        return Redirect::route('profile.edit')->with('success', 'Senha atualizada com sucesso!');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('success', 'Sua conta foi excluída permanentemente.');
    }
}