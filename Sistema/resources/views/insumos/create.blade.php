@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-slate-800">Novo Insumo</h1>
        <p class="text-slate-500 mt-1">Cadastre um novo insumo na sua lista geral.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden relative">
        <div class="absolute top-0 left-0 w-2 h-full bg-primary-500"></div>
        <div class="p-6 sm:p-8">
            <form action="{{ route('insumos.store') }}" method="POST" class="space-y-6">
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
                    <label for="nome" class="block text-sm font-medium text-slate-700 mb-1">Nome do Insumo</label>
                    <input type="text" name="nome" id="nome" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" placeholder="Semente de Soja / Fertilizante NPK" required>
                </div>

                <div>
                    <label for="estoque_atual" class="block text-sm font-medium text-slate-700 mb-1">Estoque Atual (Opcional)</label>
                    <input type="number" step="0.01" name="estoque_atual" id="estoque_atual" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" placeholder="50">
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                    <button type="submit" class="inline-flex justify-center items-center px-6 py-2.5 bg-primary-600 border border-transparent rounded-xl font-bold text-sm text-white shadow-md shadow-primary-500/30 hover:bg-primary-700 hover:shadow-lg hover:shadow-primary-600/40 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-200">
                        Salvar Insumo
                    </button>
                    <a href="{{ route('insumos.index') }}" class="text-sm font-medium text-slate-600 bg-white px-4 py-2.5 rounded-xl border border-slate-200 shadow-sm hover:bg-slate-50 transition-colors">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection