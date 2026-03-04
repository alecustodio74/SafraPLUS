@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-slate-800">Novo Maquinário</h1>
        <p class="text-slate-500 mt-1">Cadastre um novo veículo ou equipamento para sua fazenda.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden relative">
        <div class="absolute top-0 left-0 w-2 h-full bg-primary-500"></div>
        <div class="p-6 sm:p-8">
            <form action="{{ route('maquinarios.store') }}" method="POST" class="space-y-6">
                @csrf

                @can('is-admin')
                <div>
                    <label for="produtor_id" class="block text-sm font-medium text-slate-700 mb-1">Produtor</label>
                    <div class="relative">
                        <select name="produtor_id" id="produtor_id" class="w-full appearance-none border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5 pr-8" required>
                            <option value="">Selecione um produtor</option>
                            @foreach($produtores as $produtor)
                            <option value="{{ $produtor->id }}">{{ $produtor->nome }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 md:px-3 text-slate-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
                @endcan

                <div>
                    <label for="nome" class="block text-sm font-medium text-slate-700 mb-1">Nome</label>
                    <input type="text" name="nome" id="nome" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" placeholder="Trator / Colheitadeira" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="marca" class="block text-sm font-medium text-slate-700 mb-1">Marca</label>
                        <input type="text" name="marca" id="marca" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" placeholder="John Deere">
                    </div>
                    <div>
                        <label for="modelo" class="block text-sm font-medium text-slate-700 mb-1">Modelo</label>
                        <input type="text" name="modelo" id="modelo" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" placeholder="6170M">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="ano" class="block text-sm font-medium text-slate-700 mb-1">Ano</label>
                        <input type="number" name="ano" id="ano" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" placeholder="2023">
                    </div>
                    <div>
                        <label for="custo_hora" class="block text-sm font-medium text-slate-700 mb-1">Custo/Hora (Opcional)</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500">
                                R$
                            </div>
                            <input type="number" step="0.01" name="custo_hora" id="custo_hora" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5 pl-10" placeholder="150.00">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="descricao_atividade" class="block text-sm font-medium text-slate-700 mb-1">Descrição da Atividade (Opcional)</label>
                    <textarea name="descricao_atividade" id="descricao_atividade" rows="3" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" placeholder="Arar terra para plantação..."></textarea>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                    <button type="submit" class="inline-flex justify-center items-center px-6 py-2.5 bg-primary-600 border border-transparent rounded-xl font-bold text-sm text-white shadow-md shadow-primary-500/30 hover:bg-primary-700 hover:shadow-lg hover:shadow-primary-600/40 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-200">
                        Salvar Maquinário
                    </button>
                    <a href="{{ route('maquinarios.index') }}" class="text-sm font-medium text-slate-600 bg-white px-4 py-2.5 rounded-xl border border-slate-200 shadow-sm hover:bg-slate-50 transition-colors">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection