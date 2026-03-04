@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-slate-800">Editar Custo Operacional</h1>
        <p class="text-slate-500 mt-1">Altere os dados deste custo operacional.</p>
    </div>

    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm mb-6">
            <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <form action="{{ route('custos-operacionais.update', $custo->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Safra ID -->
                    <div class="md:col-span-2">
                        <label for="safra_id" class="block text-sm font-medium text-slate-700 mb-1">Associar Custo à Safra <span class="text-red-500">*</span></label>
                        <select name="safra_id" id="safra_id" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5 appearance-none" required>
                            <option value="">Selecione uma safra</option>
                            @foreach($safras as $safra)
                                <option value="{{ $safra->id }}" {{ (old('safra_id') ?? $custo->safra_id) == $safra->id ? 'selected' : '' }}>
                                    {{ $safra->cultura }} (Início: {{ \Carbon\Carbon::parse($safra->data_inicio)->format('d/m/Y') }})
                                </option>
                            @endforeach
                        </select>
                        @error('safra_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descrição -->
                    <div class="md:col-span-2">
                        <label for="descricao" class="block text-sm font-medium text-slate-700 mb-1">Descrição <span class="text-red-500">*</span></label>
                        <input type="text" name="descricao" id="descricao" value="{{ old('descricao', $custo->descricao) }}" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2" required placeholder="Ex: Combustível, Manutenção...">
                        @error('descricao')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Data -->
                    <div>
                        <label for="data" class="block text-sm font-medium text-slate-700 mb-1">Data <span class="text-red-500">*</span></label>
                        <input type="date" name="data" id="data" value="{{ old('data', $custo->data) }}" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2" required>
                        @error('data')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Valor -->
                    <div>
                        <label for="valor" class="block text-sm font-medium text-slate-700 mb-1">Valor <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-slate-500 sm:text-sm">R$</span>
                            </div>
                            <input type="number" step="0.01" name="valor" id="valor" value="{{ old('valor', $custo->valor) }}" class="w-full pl-10 border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2" required placeholder="0,00">
                        </div>
                        @error('valor')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100">
                    <h3 class="text-sm font-semibold text-slate-800 mb-4 uppercase tracking-wider">Vincular a (Opcional)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Maquinário -->
                        <div>
                            <label for="maquinario_id" class="block text-sm font-medium text-slate-700 mb-1">Maquinário</label>
                            <select name="maquinario_id" id="maquinario_id" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5 appearance-none">
                                <option value="">Nenhum selecionado</option>
                                @foreach($maquinarios as $maquinario)
                                    <option value="{{ $maquinario->id }}" {{ (old('maquinario_id') ?? $custo->maquinario_id) == $maquinario->id ? 'selected' : '' }}>
                                        {{ $maquinario->nome }}
                                    </option>
                                @endforeach
                            </select>
                            @error('maquinario_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mão de Obra -->
                        <div>
                            <label for="mao_de_obra_id" class="block text-sm font-medium text-slate-700 mb-1">Mão de Obra</label>
                            <select name="mao_de_obra_id" id="mao_de_obra_id" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5 appearance-none">
                                <option value="">Nenhum selecionado</option>
                                @foreach($maoDeObras as $item)
                                    <option value="{{ $item->id }}" {{ (old('mao_de_obra_id') ?? $custo->mao_de_obra_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->nome_ou_tipo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mao_de_obra_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('custos-operacionais.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-xl shadow-sm hover:bg-slate-50 focus:ring-4 focus:ring-slate-100 transition-all">
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