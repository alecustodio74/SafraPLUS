@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-slate-800">Editar Movimentação de Estoque</h1>
        <p class="text-slate-500 mt-1">Altere os dados desta movimentação.</p>
    </div>

    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm mb-6">
            <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden"
         x-data="{ 
            tipo: '{{ old('tipo_movimentacao', $movimentacao->tipo_movimentacao) }}' 
         }">
        <div class="p-6 sm:p-8">
            <form action="{{ route('movimentacoes-estoque.update', $movimentacao->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tipo de Movimentação -->
                    <div class="md:col-span-2">
                        <label for="tipo_movimentacao" class="block text-sm font-medium text-slate-700 mb-1">Tipo de Movimentação</label>
                        <select 
                            name="tipo_movimentacao" 
                            id="tipo_movimentacao" 
                            x-model="tipo"
                            class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5 appearance-none" 
                            required>
                            <option value="entrada">Entrada por Compra</option>
                            <option value="saida">Saída para Uso</option>
                        </select>
                        @error('tipo_movimentacao')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Insumo -->
                    <div class="md:col-span-2">
                        <label for="insumo_id" class="block text-sm font-medium text-slate-700 mb-1">Insumo</label>
                        <select name="insumo_id" id="insumo_id" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5 appearance-none" required>
                            <option value="">Selecione um insumo</option>
                            @foreach($insumos as $insumo)
                            <option value="{{ $insumo->id }}" {{ (old('insumo_id') ?? $movimentacao->insumo_id) == $insumo->id ? 'selected' : '' }}>
                                {{ $insumo->nome }} (Estoque: {{ $insumo->estoque_atual }} {{ $insumo->unidade_medida }})
                            </option>
                            @endforeach
                        </select>
                        @error('insumo_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantidade -->
                    <div>
                        <label for="quantidade" class="block text-sm font-medium text-slate-700 mb-1">Quantidade</label>
                        <input type="number" step="0.01" name="quantidade" id="quantidade" value="{{ old('quantidade', $movimentacao->quantidade) }}" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2" required>
                        @error('quantidade')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data da Movimentação -->
                    <div>
                        <label for="data_movimentacao" class="block text-sm font-medium text-slate-700 mb-1">Data da Movimentação</label>
                        <input type="date" name="data_movimentacao" id="data_movimentacao" value="{{ old('data_movimentacao', $movimentacao->data_movimentacao ?? date('Y-m-d')) }}" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2" required>
                        @error('data_movimentacao')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Valor Unitário (Conditional) -->
                    <div x-show="tipo === 'entrada'" x-transition class="md:col-span-2" style="display: none;">
                        <label for="valor_unitario" class="block text-sm font-medium text-slate-700 mb-1">Valor Unitário (Obrigatório p/ Entrada)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-slate-500 sm:text-sm">R$</span>
                            </div>
                            <input type="number" step="0.01" name="valor_unitario" id="valor_unitario" value="{{ old('valor_unitario', $movimentacao->valor_unitario) }}" class="w-full pl-10 border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2" placeholder="0,00" x-bind:required="tipo === 'entrada'">
                        </div>
                        @error('valor_unitario')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Safra Destino (Conditional) -->
                    <div x-show="tipo === 'saida'" x-transition class="md:col-span-2" style="display: none;">
                        <label for="safra_id" class="block text-sm font-medium text-slate-700 mb-1">Associar Saída à Safra (Obrigatório p/ Saída)</label>
                        <select name="safra_id" id="safra_id" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5 appearance-none" x-bind:required="tipo === 'saida'">
                            <option value="">Nenhuma Safra Selecionada</option>
                            @foreach($safras as $safra)
                            <option value="{{ $safra->id }}" {{ (old('safra_id') ?? $movimentacao->safra_id) == $safra->id ? 'selected' : '' }}>
                                {{ $safra->cultura }}
                            </option>
                            @endforeach
                        </select>
                        @error('safra_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('movimentacoes-estoque.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-xl shadow-sm hover:bg-slate-50 focus:ring-4 focus:ring-slate-100 transition-all">
                        Cancelar
                    </a>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-xl shadow-sm hover:bg-primary-700 focus:ring-4 focus:ring-primary-500/30 transition-all">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection