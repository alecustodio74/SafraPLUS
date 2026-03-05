@extends('layouts.app')

@section('header_title', 'Editar Mão de Obra')

@section('content')
<div class="mb-6">
    <p class="text-sm text-gray-500 mt-1">Atualize as informações deste funcionário ou serviço.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden max-w-2xl">
    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-indigo-500"></div>
    
    <div class="p-8 pl-10">
        <form action="{{ route('mao-de-obra.update', $maoDeObra->id) }}" method="POST">
            @csrf
            @method('PUT')

            @can('is-admin')
            <div class="mb-5">
                <label for="produtor_id" class="block text-sm font-medium text-gray-700 mb-2">Produtor</label>
                <select name="produtor_id" id="produtor_id" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 px-4 py-3 transition-colors outline-none" required>
                    <option value="">Selecione um produtor</option>
                    @foreach($produtores as $produtor)
                    <option value="{{ $produtor->id }}" {{ $maoDeObra->produtor_id == $produtor->id ? 'selected' : '' }}>
                        {{ $produtor->nome }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endcan

            <div class="mb-5">
                <label for="nome_ou_tipo" class="block text-sm font-medium text-gray-700 mb-2">Nome / Tipo</label>
                <input type="text" name="nome_ou_tipo" id="nome_ou_tipo" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 px-4 py-3 transition-colors outline-none" value="{{ $maoDeObra->nome_ou_tipo }}" required placeholder="Funcionário / Tratorista">
            </div>

            <div class="mb-6">
                <label for="custo_diario_hora" class="block text-sm font-medium text-gray-700 mb-2">Custo (Diário/Hora)</label>
                <input type="number" step="0.01" name="custo_diario_hora" id="custo_diario_hora" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 px-4 py-3 transition-colors outline-none" value="{{ $maoDeObra->custo_diario_hora }}" placeholder="Ex: 150,00">
            </div>

            <div class="pt-2 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors shadow-sm">
                    Salvar Alterações
                </button>
                <a href="{{ route('mao-de-obra.index') }}" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection