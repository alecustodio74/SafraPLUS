@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-display font-bold text-slate-800">Nova Safra</h1>
        <p class="text-slate-500 mt-1">Abra uma nova temporada de plantio e cadastre seus detalhes.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden relative">
        <div class="absolute top-0 left-0 w-2 h-full bg-orange-500"></div>
        <div class="p-6 sm:p-8">
            <form action="{{ route('safras.store') }}" method="POST" class="space-y-6">
                @csrf

                @can('is-admin')
                    <div class="mb-6">
                        <label for="produtor_id" class="block text-sm font-medium text-slate-700 mb-1">Produtor Responsável</label>
                        <select name="produtor_id" id="produtor_id" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm transition-colors px-4 py-2.5 appearance-none">
                            <option value="">Selecione um produtor</option>
                            @foreach($produtores as $produtor)
                                <option value="{{ $produtor->id }}">{{ $produtor->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                @endcan

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Componente Alpine.js para Cultura -->
                    <div x-data="{ 
                            culturaSelecionada: '', 
                            outraCultura: false,
                            init() {
                                this.$watch('culturaSelecionada', value => {
                                    this.outraCultura = value === 'outros';
                                    if(this.outraCultura) {
                                        setTimeout(() => this.$refs.inputCultura.focus(), 50);
                                    }
                                });
                            }
                        }">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Cultura</label>
                        
                        <!-- Select Principal -->
                        <select 
                            x-model="culturaSelecionada" 
                            x-bind:name="outraCultura ? '' : 'cultura'"
                            x-bind:required="!outraCultura"
                            class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm transition-colors px-4 py-2.5 appearance-none mb-2"
                        >
                            <option value="" disabled selected>Selecione a cultura</option>
                            @foreach($culturas as $cult)
                                <option value="{{ $cult }}">{{ $cult }}</option>
                            @endforeach
                            <option value="outros" class="font-bold text-orange-600">Outros (Digitar...)</option>
                        </select>

                        <!-- Input Condicional para Outros -->
                        <div 
                            x-show="outraCultura" 
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            style="display: none;"
                        >
                            <input 
                                x-ref="inputCultura"
                                type="text" 
                                x-bind:name="outraCultura ? 'cultura' : ''"
                                x-bind:required="outraCultura"
                                class="w-full border-slate-300 bg-white text-slate-900 focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-inner transition-colors px-4 py-2.5" 
                                placeholder="Digite o nome da cultura..."
                            >
                        </div>
                    </div>

                    <div>
                        <label for="area_plantada" class="block text-sm font-medium text-slate-700 mb-1">Área Plantada (Hectares)</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="area_plantada" id="area_plantada" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm transition-colors pr-12 pl-4 py-2.5" placeholder="Ex: 200">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-slate-500 text-sm font-medium">ha</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="data_inicio" class="block text-sm font-medium text-slate-700 mb-1">Data de Início do Plantio</label>
                        <input type="date" name="data_inicio" id="data_inicio" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" required>
                    </div>
                    <div>
                        <label for="data_fim" class="block text-sm font-medium text-slate-700 mb-1">Data de Fim (Opcional)</label>
                        <input type="date" name="data_fim" id="data_fim" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm transition-colors px-4 py-2.5 text-slate-500">
                        <p class="text-xs text-slate-500 mt-1">Preencha ao finalizar a colheita desta safra.</p>
                    </div>
                </div>

                <div>
                    <label for="localizacao" class="block text-sm font-medium text-slate-700 mb-1">Localização (Talhão, Fazenda, etc)</label>
                    <input type="text" name="localizacao" id="localizacao" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" placeholder="Ex: Sede Talhão 4, ou Fazenda Esperança">
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                    <button type="submit" class="inline-flex justify-center items-center px-6 py-2.5 bg-orange-600 border border-transparent rounded-xl font-bold text-sm text-white shadow-md shadow-orange-500/30 hover:bg-orange-700 hover:shadow-lg hover:shadow-orange-600/40 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-all duration-200">
                        Salvar Safra
                    </button>
                    <a href="{{ route('safras.index') }}" class="text-sm font-medium text-slate-600 bg-white px-4 py-2.5 rounded-xl border border-slate-200 shadow-sm hover:bg-slate-50 transition-colors">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection