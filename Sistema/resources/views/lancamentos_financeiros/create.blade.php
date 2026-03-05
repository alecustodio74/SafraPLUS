@extends('layouts.app')

@section('header_title', 'Novo Lançamento Financeiro')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <p class="text-sm text-gray-500 mt-1">Registre as movimentações financeiras das suas safras.</p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden max-w-2xl">
    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-blue-500"></div>
    
    <div class="p-8 pl-10">
        <form action="{{ route('lancamentos-financeiros.store') }}" method="POST">
            @csrf

            <div class="flex flex-col md:flex-row gap-5 mb-5">
                <div class="flex-1">
                    <label for="safra_id" class="block text-sm font-medium text-gray-700 mb-2">Safra</label>
                    <select name="safra_id" id="safra_id" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 px-4 py-3 transition-colors outline-none @error('safra_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" required>
                        <option value="">Selecione a safra</option>
                        @foreach($safras as $safra)
                            <option value="{{ $safra->id }}" {{ old('safra_id') == $safra->id ? 'selected' : '' }}>
                                {{ $safra->cultura }} ({{ \Carbon\Carbon::parse($safra->data_inicio)->format('d/m/Y') }})
                            </option>
                        @endforeach
                    </select>
                    @error('safra_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex-1">
                    <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-2">Categoria</label>
                    <select name="categoria_id" id="categoria_id" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 px-4 py-3 transition-colors outline-none @error('categoria_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" required>
                        <option value="">Selecione a categoria</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-5 mb-5">
                <div class="flex-1">
                    <label for="tipo_receita_custo" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Lançamento</label>
                    <select name="tipo_receita_custo" id="tipo_receita_custo" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 px-4 py-3 transition-colors outline-none @error('tipo_receita_custo') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" required>
                        <option value="">Selecione o tipo</option>
                        <option value="receita" {{ old('tipo_receita_custo') == 'receita' ? 'selected' : '' }}>Receita</option>
                        <option value="custo" {{ old('tipo_receita_custo') == 'custo' ? 'selected' : '' }}>Despesa</option>
                    </select>
                    @error('tipo_receita_custo')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex-1">
                    <label for="data_lancamento" class="block text-sm font-medium text-gray-700 mb-2">Data</label>
                    <input type="date" name="data_lancamento" id="data_lancamento" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 px-4 py-3 transition-colors outline-none @error('data_lancamento') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" value="{{ old('data_lancamento', date('Y-m-d')) }}" required>
                    @error('data_lancamento')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-5">
                <label for="descricao" class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                <input type="text" name="descricao" id="descricao" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 px-4 py-3 transition-colors outline-none @error('descricao') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" value="{{ old('descricao') }}" required placeholder="Ex: Sementes de Milho, Venda de Soja">
                @error('descricao')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="valor_total" class="block text-sm font-medium text-gray-700 mb-2">Valor Total</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span class="text-gray-500 font-medium">R$</span>
                    </div>
                    <input type="number" step="0.01" name="valor_total" id="valor_total" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-blue-500 focus:border-blue-500 pl-11 pr-4 py-3 transition-colors outline-none @error('valor_total') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" value="{{ old('valor_total') }}" required placeholder="0,00">
                </div>
                @error('valor_total')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                    Salvar Lançamento
                </button>
                <a href="{{ route('lancamentos-financeiros.index') }}" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection