@extends('layouts.app')

@section('header_title', 'Editar Administrador')

@section('content')

<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Editar Administrador</h2>
    <p class="text-sm text-gray-500 mt-1">Atualize as informações deste administrador.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden max-w-2xl">
    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-purple-500"></div>
    
    <div class="p-8 pl-10">
        <form action="{{ route('administradores.update', $administrador->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-5">
                <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">Nome Completo</label>
                <input type="text" name="nome" id="nome" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-purple-500 focus:border-purple-500 px-4 py-3 transition-colors outline-none" value="{{ $administrador->nome }}" required placeholder="Carlos Albuquerque Dias">
            </div>

            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email (Login)</label>
                <input type="email" name="email" id="email" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-purple-500 focus:border-purple-500 px-4 py-3 transition-colors outline-none" value="{{ $administrador->email }}" required placeholder="email@email.com">
            </div>

            <div class="mb-5">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nova Senha (Opcional)</label>
                <input type="password" name="password" id="password" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-purple-500 focus:border-purple-500 px-4 py-3 transition-colors outline-none" placeholder="Deixe em branco para não alterar">
            </div>
            
            <div class="flex flex-col md:flex-row gap-5 mb-6">
                <div class="flex-1">
                    <label for="cpf_cnpj" class="block text-sm font-medium text-gray-700 mb-2">CPF / CNPJ</label>
                    <input type="text" name="cpf_cnpj" id="cpf_cnpj" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-purple-500 focus:border-purple-500 px-4 py-3 transition-colors outline-none" value="{{ $administrador->cpf_cnpj }}" required placeholder="***.***.***-**">
                </div>
                <div class="flex-1">
                    <label for="telefone" class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
                    <input type="text" name="telefone" id="telefone" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-purple-500 focus:border-purple-500 px-4 py-3 transition-colors outline-none" value="{{ $administrador->telefone }}" placeholder="(18) 99424-4563">
                </div>
            </div>

            <input type="hidden" name="role" value="admin">

            <div class="pt-2 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-purple-600 text-white font-semibold rounded-xl hover:bg-purple-700 transition-colors shadow-sm">
                    Salvar Alterações
                </button>
                <a href="{{ route('administradores.index') }}" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

@endsection