@extends('layouts.app')

@section('header_title', 'Editar Insumo')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Editar Insumo</h2>
    <p class="text-sm text-gray-500 mt-1">Atualize as informações deste produto.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden max-w-2xl">
    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-blue-500"></div>
    
    <div class="p-8 pl-10">
        <form action="{{ route('insumos.update', $insumo->id) }}" method="POST">
            @csrf
            @method('PUT')

            @can('is-admin')
            <div class="mb-5">
                <label for="produtor_id" class="block text-sm font-medium text-gray-700 mb-2">Produtor</label>
                <select name="produtor_id" id="produtor_id" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 px-4 py-3 transition-colors outline-none" required>
                    <option value="">Selecione um produtor</option>
                    @foreach($produtores as $produtor)
                    <option value="{{ $produtor->id }}" {{ $insumo->produtor_id == $produtor->id ? 'selected' : '' }}>
                        {{ $produtor->nome }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endcan

            <div class="mb-5">
                <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">Nome do Insumo</label>
                <input type="text" name="nome" id="nome" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 px-4 py-3 transition-colors outline-none" value="{{ $insumo->nome }}" required placeholder="Semente de Soja / Fertilizante NPK">
            </div>

            <div class="mb-6">
                <label for="estoque_atual" class="block text-sm font-medium text-gray-700 mb-2">Estoque Inicial / Atual</label>
                <input type="number" step="0.01" name="estoque_atual" id="estoque_atual" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 px-4 py-3 transition-colors outline-none" value="{{ $insumo->estoque_atual }}" placeholder="Ex: 50">
            </div>

            <div class="pt-2 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                    Salvar Alterações
                </button>
                <a href="{{ route('insumos.index') }}" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection