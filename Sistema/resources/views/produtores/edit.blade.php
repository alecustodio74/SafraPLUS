@extends('layouts.app')

@section('header_title', 'Editar Produtor')

@section('content')

<div class="mb-6">
    <p class="text-sm text-gray-500 mt-1">Atualize as informações deste produtor.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden max-w-2xl">
    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#059669]"></div>
    
    <div class="p-8 pl-10">
        <form action="{{ route('produtores.update', $produtor->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-5">
                <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">Nome Completo</label>
                <input type="text" name="nome" id="nome" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-[#059669] focus:border-[#059669] px-4 py-3 transition-colors outline-none" value="{{ $produtor->nome }}" required placeholder="Henrique Cruz de Lima">
            </div>

            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email (Login)</label>
                <input type="email" name="email" id="email" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-[#059669] focus:border-[#059669] px-4 py-3 transition-colors outline-none" value="{{ $produtor->email }}" required placeholder="email@email.com">
            </div>

            <div class="mb-5">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nova Senha (Opcional)</label>
                <input type="password" name="password" id="password" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-[#059669] focus:border-[#059669] px-4 py-3 transition-colors outline-none" placeholder="Deixe em branco para não alterar">
            </div>
            
            <div class="flex flex-col md:flex-row gap-5 mb-5">
                <div class="flex-1">
                    <label for="cpf_cnpj" class="block text-sm font-medium text-gray-700 mb-2">CPF / CNPJ (apenas números)</label>
                    <input type="text" name="cpf_cnpj" id="cpf_cnpj" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-[#059669] focus:border-[#059669] px-4 py-3 transition-colors outline-none" value="{{ $produtor->cpf_cnpj }}" required placeholder="***.***.***-**">
                </div>
                <div class="flex-1">
                    <label for="telefone" class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
                    <input type="text" name="telefone" id="telefone" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-[#059669] focus:border-[#059669] px-4 py-3 transition-colors outline-none" value="{{ $produtor->telefone }}" placeholder="(18) 99364-6367">
                </div>
            </div>

            <div class="mb-5">
                <label for="propriedade" class="block text-sm font-medium text-gray-700 mb-2">Nome da Propriedade</label>
                <input type="text" name="propriedade" id="propriedade" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-[#059669] focus:border-[#059669] px-4 py-3 transition-colors outline-none" value="{{ $produtor->propriedade }}" placeholder="Fazenda São Joaquim">
            </div>

            <div class="mb-6">
                <label for="cultura_principal" class="block text-sm font-medium text-gray-700 mb-2">Cultura Principal</label>
                <input type="text" name="cultura_principal" id="cultura_principal" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-[#059669] focus:border-[#059669] px-4 py-3 transition-colors outline-none" value="{{ $produtor->cultura_principal }}" placeholder="Arroz / Milho / Soja">
            </div>

            <div class="pt-2 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-[#059669] text-white font-semibold rounded-xl hover:bg-[#047857] transition-colors shadow-sm">
                    Salvar Alterações
                </button>
                <a href="{{ route('produtores.index') }}" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

@endsection