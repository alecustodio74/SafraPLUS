@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-slate-800">Cadastrar Administrador</h1>
        <p class="text-slate-500 mt-1">Conceda acesso gerencial completo a um novo usuário.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden relative">
        <div class="absolute top-0 left-0 w-2 h-full bg-purple-500"></div>
        <div class="p-6 sm:p-8">
            <form action="{{ route('administradores.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="bg-purple-50 text-purple-800 p-4 rounded-xl border border-purple-100 flex gap-3 text-sm mb-6">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p>O usuário criado aqui terá acesso irrestrito a todas as funcionalidades do painel administrativo, incluindo a exclusão de dados.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nome" class="block text-sm font-medium text-slate-700 mb-1">Nome Completo</label>
                        <input type="text" name="nome" id="nome" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-purple-500 focus:ring-purple-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" required placeholder="Ex: Carlos Albuquerque">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email (Usado para Login)</label>
                        <input type="email" name="email" id="email" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-purple-500 focus:ring-purple-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" required autocomplete="username" placeholder="carlos@fazenda.com">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Senha Segura</label>
                        <input type="password" name="password" id="password" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-purple-500 focus:ring-purple-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" required autocomplete="new-password" placeholder="••••••••">
                    </div>
                    <div>
                        <label for="telefone" class="block text-sm font-medium text-slate-700 mb-1">Telefone de Contato</label>
                        <input type="text" name="telefone" id="telefone" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-purple-500 focus:ring-purple-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" placeholder="(18) 99999-9999">
                    </div>
                </div>
                
                <div>
                    <label for="cpf_cnpj" class="block text-sm font-medium text-slate-700 mb-1">CPF / CNPJ</label>
                    <input type="text" name="cpf_cnpj" id="cpf_cnpj" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-purple-500 focus:ring-purple-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" required placeholder="000.000.000-00">
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                    <button type="submit" class="inline-flex justify-center items-center px-6 py-2.5 bg-purple-600 border border-transparent rounded-xl font-bold text-sm text-white shadow-md shadow-purple-500/30 hover:bg-purple-700 hover:shadow-lg hover:shadow-purple-600/40 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all duration-200">
                        Salvar Administrador
                    </button>
                    <a href="{{ route('administradores.index') }}" class="text-sm font-medium text-slate-600 bg-white px-4 py-2.5 rounded-xl border border-slate-200 shadow-sm hover:bg-slate-50 transition-colors">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection