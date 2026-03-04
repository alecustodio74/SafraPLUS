@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-slate-800">Novo Lançamento Financeiro</h1>
        <p class="text-slate-500 mt-1">Registre uma nova receita ou despesa associada a uma safra.</p>
    </div>

    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm mb-6">
            <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden" x-data="{ tipoLancamento: '{{ old('tipo_receita_custo', '') }}' }">
        <div class="p-6 sm:p-8">
            <form action="{{ route('lancamentos-financeiros.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Tipo de Lançamento (Receita/Despesa) - Moved to top for better flow -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-3">Tipo de Lançamento <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative flex cursor-pointer rounded-xl border p-4 shadow-sm focus:outline-none"
                                   :class="tipoLancamento === 'receita' ? 'bg-emerald-50 border-emerald-500 ring-1 ring-emerald-500' : 'bg-white border-slate-200 hover:bg-slate-50'">
                                <input type="radio" name="tipo_receita_custo" value="receita" class="sr-only" x-model="tipoLancamento" required>
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span class="block text-sm font-medium" :class="tipoLancamento === 'receita' ? 'text-emerald-900' : 'text-slate-900'">Receita</span>
                                        <span class="mt-1 flex items-center text-sm" :class="tipoLancamento === 'receita' ? 'text-emerald-700' : 'text-slate-500'">Entrada de valores.</span>
                                    </span>
                                </span>
                                <svg class="h-5 w-5" :class="tipoLancamento === 'receita' ? 'text-emerald-600' : 'text-transparent'" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </label>

                            <label class="relative flex cursor-pointer rounded-xl border p-4 shadow-sm focus:outline-none"
                                   :class="tipoLancamento === 'custo' ? 'bg-rose-50 border-rose-500 ring-1 ring-rose-500' : 'bg-white border-slate-200 hover:bg-slate-50'">
                                <input type="radio" name="tipo_receita_custo" value="custo" class="sr-only" x-model="tipoLancamento" required>
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span class="block text-sm font-medium" :class="tipoLancamento === 'custo' ? 'text-rose-900' : 'text-slate-900'">Despesa</span>
                                        <span class="mt-1 flex items-center text-sm" :class="tipoLancamento === 'custo' ? 'text-rose-700' : 'text-slate-500'">Saída de valores.</span>
                                    </span>
                                </span>
                                <svg class="h-5 w-5" :class="tipoLancamento === 'custo' ? 'text-rose-600' : 'text-transparent'" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </label>
                        </div>
                        @error('tipo_receita_custo')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Safra ID -->
                    <div class="md:col-span-2">
                        <label for="safra_id" class="block text-sm font-medium text-slate-700 mb-1">Safra <span class="text-red-500">*</span></label>
                        <select name="safra_id" id="safra_id" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5 appearance-none" required>
                            <option value="">Selecione a safra</option>
                            @foreach($safras as $safra)
                                <option value="{{ $safra->id }}" {{ old('safra_id') == $safra->id ? 'selected' : '' }}>
                                    {{ $safra->cultura }} (Início: {{ \Carbon\Carbon::parse($safra->data_inicio)->format('d/m/Y') }})
                                </option>
                            @endforeach
                        </select>
                        @error('safra_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Categoria ID -->
                    <div class="md:col-span-2">
                        <label for="categoria_id" class="block text-sm font-medium text-slate-700 mb-1">Categoria <span class="text-red-500">*</span></label>
                        <select name="categoria_id" id="categoria_id" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5 appearance-none" required>
                            <option value="">Selecione a categoria</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descrição -->
                    <div class="md:col-span-2">
                        <label for="descricao" class="block text-sm font-medium text-slate-700 mb-1">Descrição <span class="text-red-500">*</span></label>
                        <input type="text" name="descricao" id="descricao" value="{{ old('descricao') }}" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2" required placeholder="Ex: Venda de Soja, Compra de Sementes...">
                        @error('descricao')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Valor Total -->
                    <div>
                        <label for="valor_total" class="block text-sm font-medium text-slate-700 mb-1">Valor Total <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-slate-500 sm:text-sm">R$</span>
                            </div>
                            <input type="number" step="0.01" name="valor_total" id="valor_total" value="{{ old('valor_total') }}" class="w-full pl-10 border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2" required placeholder="0,00">
                        </div>
                        @error('valor_total')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data do Lançamento -->
                    <div>
                        <label for="data_lancamento" class="block text-sm font-medium text-slate-700 mb-1">Data do Lançamento <span class="text-red-500">*</span></label>
                        <input type="date" name="data_lancamento" id="data_lancamento" value="{{ old('data_lancamento', date('Y-m-d')) }}" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2" required>
                        @error('data_lancamento')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('lancamentos-financeiros.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-xl shadow-sm hover:bg-slate-50 focus:ring-4 focus:ring-slate-100 transition-all">
                        Cancelar
                    </a>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-xl shadow-sm hover:bg-primary-700 focus:ring-4 focus:ring-primary-500/30 transition-all">
                        Salvar Lançamento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection