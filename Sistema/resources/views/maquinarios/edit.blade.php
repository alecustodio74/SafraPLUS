@extends('layouts.app')

@section('header_title', 'Editar Maquinário')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Editar Maquinário</h2>
    <p class="text-sm text-gray-500 mt-1">Atualize as informações desta máquina.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden max-w-2xl">
    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-amber-500"></div>
    
    <div class="p-8 pl-10">
        <form action="{{ route('maquinarios.update', $maquinario->id) }}" method="POST">
            @csrf
            @method('PUT')

            @can('is-admin')
            <div class="mb-5">
                <label for="produtor_id" class="block text-sm font-medium text-gray-700 mb-2">Produtor</label>
                <select name="produtor_id" id="produtor_id" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-amber-500 focus:border-amber-500 px-4 py-3 transition-colors outline-none" required>
                    <option value="">Selecione um produtor</option>
                    @foreach($produtores as $produtor)
                    <option value="{{ $produtor->id }}" {{ $maquinario->produtor_id == $produtor->id ? 'selected' : '' }}>
                        {{ $produtor->nome }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endcan

            <div class="mb-5">
                <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">Nome</label>
                <input type="text" name="nome" id="nome" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-amber-500 focus:border-amber-500 px-4 py-3 transition-colors outline-none" value="{{ $maquinario->nome }}" required placeholder="Trator">
            </div>
            
            <div class="flex flex-col md:flex-row gap-5 mb-5">
                <div class="flex-1">
                    <label for="marca" class="block text-sm font-medium text-gray-700 mb-2">Marca</label>
                    <input type="text" name="marca" id="marca" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-amber-500 focus:border-amber-500 px-4 py-3 transition-colors outline-none" value="{{ $maquinario->marca }}" placeholder="John Deere">
                </div>
                <div class="flex-1">
                    <label for="modelo" class="block text-sm font-medium text-gray-700 mb-2">Modelo</label>
                    <input type="text" name="modelo" id="modelo" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-amber-500 focus:border-amber-500 px-4 py-3 transition-colors outline-none" value="{{ $maquinario->modelo }}" placeholder="6170M">
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row gap-5 mb-5">
                <div class="flex-1">
                    <label for="ano" class="block text-sm font-medium text-gray-700 mb-2">Ano</label>
                    <input type="number" name="ano" id="ano" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-amber-500 focus:border-amber-500 px-4 py-3 transition-colors outline-none" value="{{ $maquinario->ano }}" placeholder="2025">
                </div>
                <div class="flex-1">
                    <label for="custo_hora" class="block text-sm font-medium text-gray-700 mb-2">Custo/Hora (Opcional)</label>
                    <input type="number" step="0.01" name="custo_hora" id="custo_hora" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-amber-500 focus:border-amber-500 px-4 py-3 transition-colors outline-none" value="{{ $maquinario->custo_hora }}" placeholder="R$ 120,00">
                </div>
            </div>
            
            <div class="mb-6">
                <label for="descricao_atividade" class="block text-sm font-medium text-gray-700 mb-2">Série / Documento (Opcional)</label>
                <textarea name="descricao_atividade" id="descricao_atividade" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-amber-500 focus:border-amber-500 px-4 py-3 transition-colors outline-none" rows="3" placeholder="Insira a série única ou placa para identificar a máquina">{{ $maquinario->descricao_atividade }}</textarea>
            </div>

            <div class="pt-2 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-amber-500 text-white font-semibold rounded-xl hover:bg-amber-600 transition-colors shadow-sm">
                    Salvar Alterações
                </button>
                <a href="{{ route('maquinarios.index') }}" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection