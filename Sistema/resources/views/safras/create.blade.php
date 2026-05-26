@extends('layouts.app')

@section('header_title', 'Nova Safra')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <p class="text-sm text-gray-500 mt-1">Cadastre as informações de um novo plantio.</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden max-w-3xl">
    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-500"></div>
    
    <div class="p-8 pl-10">
        <form action="{{ route('safras.store') }}" method="POST">
            @csrf

            @can('is-admin')
            <div class="mb-5">
                <label for="produtor_id" class="block text-sm font-medium text-gray-700 mb-2">Produtor</label>
                <select name="produtor_id" id="produtor_id" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-colors outline-none">
                    <option value="">Selecione um produtor</option>
                    @foreach($produtores as $produtor)
                    <option value="{{ $produtor->id }}">{{ $produtor->nome }}</option>
                    @endforeach
                </select>
            </div>
            @endcan

            <div class="flex flex-col md:flex-row gap-5 mb-5">
                <div class="flex-1">
                    <label for="cultura" class="block text-sm font-medium text-gray-700 mb-2">Cultura</label>
                    <input type="text" name="cultura" id="cultura" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-colors outline-none" required placeholder="Ex: Arroz / Soja / Milho">
                </div>
                <div class="flex-1">
                    <label for="area_plantada" class="block text-sm font-medium text-gray-700 mb-2">Área (ha)</label>
                    <input type="number" step="0.01" name="area_plantada" id="area_plantada" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-colors outline-none" placeholder="Ex: 200">
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-5 mb-5">
                <div class="flex-1">
                    <label for="data_inicio" class="block text-sm font-medium text-gray-700 mb-2">Data de Início</label>
                    <input type="date" name="data_inicio" id="data_inicio" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-colors outline-none" required>
                </div>
                <div class="flex-1">
                    <label for="data_fim" class="block text-sm font-medium text-gray-700 mb-2">Data de Fim (Opcional)</label>
                    <input type="date" name="data_fim" id="data_fim" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-colors outline-none">
                </div>
            </div>

            <div class="mb-5">
                <label for="propriedade" class="block text-sm font-medium text-gray-700 mb-2">Nome da Propriedade</label>
                <input type="text" name="propriedade" id="propriedade" list="propriedades-list" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-colors outline-none" placeholder="Ex: Fazenda Bela Vista">
                <datalist id="propriedades-list">
                    @foreach($propriedades as $prop)
                        <option value="{{ $prop }}">
                    @endforeach
                </datalist>
            </div>

            <div class="mb-6">
                <div class="flex items-center gap-2 mb-2">
                    <label for="localizacao" class="block text-sm font-medium text-gray-700">Coordenadas da Localização (Google Maps)</label>
                    <div class="relative">
                        <button type="button" onclick="this.nextElementSibling.classList.toggle('hidden')" class="w-5 h-5 rounded-full bg-gray-200 text-red-600 flex items-center justify-center text-xs font-bold hover:bg-gray-300 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-1 shadow-sm">
                            ?
                        </button>
                        <div class="absolute left-1/2 -translate-x-1/2 bottom-full mb-2 hidden w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-center">
                            No Google Maps, clique com o botão direito sobre o local do plantio. Clique nos números (coordenadas) que aparecerão para copiá-los e cole aqui.
                            <div class="absolute left-1/2 -translate-x-1/2 top-full border-4 border-transparent border-t-gray-800"></div>
                        </div>
                    </div>
                </div>
                <input type="text" name="localizacao" id="localizacao" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 px-4 py-3 transition-colors outline-none" placeholder="Ex: -15.79422, -47.88216">
            </div>

            <div class="pt-2 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white font-semibold rounded-xl hover:bg-emerald-700 transition-colors shadow-sm">
                    Salvar Safra
                </button>
                <a href="{{ route('safras.index') }}" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection