@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-slate-800">Nova Mão de Obra</h1>
        <p class="text-slate-500 mt-1">Cadastre um novo colaborador ou tipo de serviço e defina seu custo.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden relative">
        <div class="absolute top-0 left-0 w-2 h-full bg-blue-500"></div>
        <div class="p-6 sm:p-8">
            <form action="{{ route('mao-de-obra.store') }}" method="POST" class="space-y-6">
                @csrf

                @can('is-admin')
                    <div class="mb-6">
                        <label for="produtor_id" class="block text-sm font-medium text-slate-700 mb-1">Produtor Vinculado</label>
                        <select name="produtor_id" id="produtor_id" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition-colors px-4 py-2.5 appearance-none" required>
                            <option value="">Selecione um produtor</option>
                            @foreach($produtores as $produtor)
                                <option value="{{ $produtor->id }}">{{ $produtor->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                @endcan

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nome_ou_tipo" class="block text-sm font-medium text-slate-700 mb-1">Nome / Tipo de Serviço</label>
                        <input type="text" name="nome_ou_tipo" id="nome_ou_tipo" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" placeholder="Ex: Diarista / Tratorista" required>
                    </div>

                    <div>
                        <label for="custo_diario_hora" class="block text-sm font-medium text-slate-700 mb-1">Custo (Diário/Hora) - R$</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-slate-500 sm:text-sm">R$</span>
                            </div>
                            <input type="number" step="0.01" name="custo_diario_hora" id="custo_diario_hora" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm transition-colors pl-9 pr-4 py-2.5" placeholder="0.00">
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                    <button type="submit" class="inline-flex justify-center items-center px-6 py-2.5 bg-blue-600 border border-transparent rounded-xl font-bold text-sm text-white shadow-md shadow-blue-500/30 hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-600/40 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                        Salvar Item
                    </button>
                    <a href="{{ route('mao-de-obra.index') }}" class="text-sm font-medium text-slate-600 bg-white px-4 py-2.5 rounded-xl border border-slate-200 shadow-sm hover:bg-slate-50 transition-colors">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection