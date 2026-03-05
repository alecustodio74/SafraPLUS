@extends('layouts.app')

@section('header_title', 'Editar Safra')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <p class="text-sm text-gray-500 mt-1">Atualize as informações sobre o plantio.</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden max-w-3xl">
    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-500"></div>
    
    <div class="p-8 pl-10">
        <form action="{{ route('safras.update', $safra->id) }}" method="POST">
            @csrf
            @method('PUT')

            @can('is-admin')
            <div class="mb-5">
                <label for="produtor_id" class="block text-sm font-medium text-gray-700 mb-2">Produtor</label>
                <select name="produtor_id" id="produtor_id" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-colors outline-none" required>
                    <option value="">Selecione um produtor</option>
                    @foreach($produtores as $produtor)
                    <option value="{{ $produtor->id }}" {{ $safra->produtor_id == $produtor->id ? 'selected' : '' }}>
                        {{ $produtor->nome }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endcan

            <div class="flex flex-col md:flex-row gap-5 mb-5">
                <div class="flex-1">
                    <label for="cultura" class="block text-sm font-medium text-gray-700 mb-2">Cultura</label>
                    <input type="text" name="cultura" id="cultura" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-colors outline-none" value="{{ $safra->cultura }}" required placeholder="Ex: Arroz / Soja / Milho">
                </div>
                <div class="flex-1">
                    <label for="area_plantada" class="block text-sm font-medium text-gray-700 mb-2">Área (ha)</label>
                    <input type="number" step="0.01" name="area_plantada" id="area_plantada" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-colors outline-none" value="{{ $safra->area_plantada }}" placeholder="Ex: 200">
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-5 mb-5">
                <div class="flex-1">
                    <label for="data_inicio" class="block text-sm font-medium text-gray-700 mb-2">Data de Início</label>
                    <input type="date" name="data_inicio" id="data_inicio" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-colors outline-none" value="{{ $safra->data_inicio }}" required>
                </div>
                <div class="flex-1">
                    <label for="data_fim" class="block text-sm font-medium text-gray-700 mb-2">Data de Fim (Opcional)</label>
                    <input type="date" name="data_fim" id="data_fim" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-colors outline-none" value="{{ $safra->data_fim }}">
                </div>
            </div>

            <div class="mb-6">
                <label for="localizacao" class="block text-sm font-medium text-gray-700 mb-2">Localização</label>
                <input type="text" name="localizacao" id="localizacao" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-colors outline-none" value="{{ $safra->localizacao }}" placeholder="Rodovia Raposo Tavares, Km 126">
            </div>

            <div class="pt-2 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-colors shadow-sm">
                    Salvar Alterações
                </button>
                <a href="{{ route('safras.index') }}" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection