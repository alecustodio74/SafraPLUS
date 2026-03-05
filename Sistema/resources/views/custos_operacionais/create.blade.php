@extends('layouts.app')

@section('header_title', 'Novo Custo Operacional')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Novo Custo Operacional</h2>
        <p class="text-sm text-gray-500 mt-1">Registre uma nova despesa ou custo associado a uma safra.</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden max-w-2xl">
    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-rose-500"></div>
    
    <div class="p-8 pl-10">
        <form action="{{ route('custos-operacionais.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label for="safra_id" class="block text-sm font-medium text-gray-700 mb-2">Associar Custo à Safra</label>
                <select name="safra_id" id="safra_id" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-rose-500 focus:border-rose-500 px-4 py-3 transition-colors outline-none" required>
                    <option value="">Selecione uma safra</option>
                    @foreach($safras as $safra)
                        <option value="{{ $safra->id }}">{{ $safra->cultura }} (Início: {{ \Carbon\Carbon::parse($safra->data_inicio)->format('d/m/Y') }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-5">
                <label for="descricao" class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                <input type="text" name="descricao" id="descricao" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-rose-500 focus:border-rose-500 px-4 py-3 transition-colors outline-none" required placeholder="Ex: Combustível, Manutenção">
            </div>

            <div class="flex flex-col md:flex-row gap-5 mb-5">
                <div class="flex-1">
                    <label for="data" class="block text-sm font-medium text-gray-700 mb-2">Data</label>
                    <input type="date" name="data" id="data" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-rose-500 focus:border-rose-500 px-4 py-3 transition-colors outline-none" required value="{{ date('Y-m-d') }}">
                </div>
                <div class="flex-1">
                    <label for="valor" class="block text-sm font-medium text-gray-700 mb-2">Valor</label>
                    <input type="number" step="0.01" name="valor" id="valor" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-rose-500 focus:border-rose-500 px-4 py-3 transition-colors outline-none" required placeholder="Ex: 500,00">
                </div>
            </div>

            <div class="pt-2 pb-4">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-3 bg-white text-xs font-medium text-gray-500 uppercase tracking-wider">Vincular a (Opcional)</span>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <label for="maquinario_id" class="block text-sm font-medium text-gray-700 mb-2">Maquinário</label>
                <select name="maquinario_id" id="maquinario_id" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-rose-500 focus:border-rose-500 px-4 py-3 transition-colors outline-none">
                    <option value="">Nenhum</option>
                    @foreach($maquinarios as $maquinario)
                        <option value="{{ $maquinario->id }}">{{ $maquinario->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label for="mao_de_obra_id" class="block text-sm font-medium text-gray-700 mb-2">Mão de Obra</label>
                <select name="mao_de_obra_id" id="mao_de_obra_id" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-rose-500 focus:border-rose-500 px-4 py-3 transition-colors outline-none">
                    <option value="">Nenhum</option>
                    @foreach($maoDeObras as $item)
                        <option value="{{ $item->id }}">{{ $item->nome_ou_tipo }}</option>
                    @endforeach
                </select>
            </div>

            <div class="pt-2 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-rose-600 text-white font-semibold rounded-xl hover:bg-rose-700 transition-colors shadow-sm">
                    Salvar Custo
                </button>
                <a href="{{ route('custos-operacionais.index') }}" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection