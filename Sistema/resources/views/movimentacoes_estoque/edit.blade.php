@extends('layouts.app')

@section('header_title', 'Editar Movimentação de Estoque')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Editar Movimentação de Estoque</h2>
        <p class="text-sm text-gray-500 mt-1">Modifique os detalhes desta movimentação.</p>
    </div>
</div>

@if (session('error'))
<div class="mb-6 p-4 rounded-xl bg-red-50 text-red-700 border border-red-200 flex items-center gap-3">
    <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
    {{ session('error') }}
</div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden max-w-2xl">
    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-teal-500"></div>
    
    <div class="p-8 pl-10">
        <form action="{{ route('movimentacoes-estoque.update', $movimentacao->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="tipo_movimentacao" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Movimentação</label>
                <select name="tipo_movimentacao" id="tipo_movimentacao" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-teal-500 focus:border-teal-500 px-4 py-3 transition-colors outline-none" required>
                    <option value="entrada" {{ $movimentacao->tipo_movimentacao == 'entrada' ? 'selected' : '' }}>Entrada por Compra</option>
                    <option value="saida" {{ $movimentacao->tipo_movimentacao == 'saida' ? 'selected' : '' }}>Saída para Uso</option>
                </select>
            </div>

            <div class="mb-5">
                <label for="insumo_id" class="block text-sm font-medium text-gray-700 mb-2">Insumo</label>
                <select name="insumo_id" id="insumo_id" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-teal-500 focus:border-teal-500 px-4 py-3 transition-colors outline-none" required>
                    <option value="">Selecione um insumo</option>
                    @foreach($insumos as $insumo)
                    <option value="{{ $insumo->id }}" {{ $movimentacao->insumo_id == $insumo->id ? 'selected' : '' }}>
                        {{ $insumo->nome }} (Estoque: {{ $insumo->estoque_atual }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col md:flex-row gap-5 mb-5">
                <div class="flex-1">
                    <label for="quantidade" class="block text-sm font-medium text-gray-700 mb-2">Quantidade</label>
                    <input type="number" step="0.01" name="quantidade" id="quantidade" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-teal-500 focus:border-teal-500 px-4 py-3 transition-colors outline-none" value="{{ $movimentacao->quantidade }}" required>
                </div>
                <div class="flex-1">
                    <label for="data_movimentacao" class="block text-sm font-medium text-gray-700 mb-2">Data da Movimentação</label>
                    <input type="date" name="data_movimentacao" id="data_movimentacao" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-teal-500 focus:border-teal-500 px-4 py-3 transition-colors outline-none @error('data_movimentacao') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" value="{{ $movimentacao->data_movimentacao ?? date('Y-m-d') }}" required>
                    @error('data_movimentacao')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-5" id="valor_unitario_wrapper" style="display: none;">
                <label for="valor_unitario" class="block text-sm font-medium text-gray-700 mb-2">Valor Unitário (Obrigatório p/ Entrada)</label>
                <input type="number" step="0.01" name="valor_unitario" id="valor_unitario" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-teal-500 focus:border-teal-500 px-4 py-3 transition-colors outline-none" value="{{ $movimentacao->valor_unitario }}">
            </div>

            <div class="mb-6" id="safra_id_wrapper" style="display: none;">
                <label for="safra_id" class="block text-sm font-medium text-gray-700 mb-2">Associar Saída à Safra (Obrigatório p/ Saída)</label>
                <select name="safra_id" id="safra_id" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-teal-500 focus:border-teal-500 px-4 py-3 transition-colors outline-none">
                    <option value="">Nenhuma</option>
                    @foreach($safras as $safra)
                    <option value="{{ $safra->id }}" {{ $movimentacao->safra_id == $safra->id ? 'selected' : '' }}>
                        {{ $safra->cultura }} (Início: {{ $safra->data_inicio }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="pt-2 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700 transition-colors shadow-sm">
                    Salvar Alterações
                </button>
                <a href="{{ route('movimentacoes-estoque.index') }}" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const tipoMovimentacao = document.getElementById('tipo_movimentacao');
        const valorUnitarioWrapper = document.getElementById('valor_unitario_wrapper');
        const safraIdWrapper = document.getElementById('safra_id_wrapper');
        const valorUnitarioInput = document.getElementById('valor_unitario');
        const safraIdInput = document.getElementById('safra_id');

        function toggleFields() {
            const tipo = tipoMovimentacao.value;

            if (tipo === 'entrada') {
                valorUnitarioWrapper.style.display = 'block';
                safraIdWrapper.style.display = 'none';
                valorUnitarioInput.required = true;
                safraIdInput.required = false;
            } else if (tipo === 'saida') {
                valorUnitarioWrapper.style.display = 'none';
                safraIdWrapper.style.display = 'block';
                valorUnitarioInput.required = false;
                safraIdInput.required = true;
            } else {
                valorUnitarioWrapper.style.display = 'none';
                safraIdWrapper.style.display = 'none';
                valorUnitarioInput.required = false;
                safraIdInput.required = false;
            }
        }
        tipoMovimentacao.addEventListener('change', toggleFields);

        toggleFields();
    });
</script>
@endsection