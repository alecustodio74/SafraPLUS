@extends('layouts.app')

@section('header_title', 'Editar Categoria')

@section('content')

<div class="mb-6">
    <p class="text-sm text-gray-500 mt-1">Atualize as informações desta categoria.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden max-w-2xl">
    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#059669]"></div>
    
    <div class="p-8 pl-10">
        <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
            @csrf
            @method('PUT')

            @can('is-admin')
            <div class="mb-5">
                <label for="produtor_id" class="block text-sm font-medium text-gray-700 mb-2">Produtor</label>
                <select name="produtor_id" id="produtor_id" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-[#059669] focus:border-[#059669] px-4 py-3 transition-colors outline-none" required>
                    <option value="">Selecione um produtor</option>
                    @foreach($produtores as $produtor)
                    <option value="{{ $produtor->id }}" {{ $categoria->produtor_id == $produtor->id ? 'selected' : '' }}>
                        {{ $produtor->nome }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endcan

            <div class="mb-5">
                <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">Nome da Categoria</label>
                <input type="text" name="nome" id="nome" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-[#059669] focus:border-[#059669] px-4 py-3 transition-colors outline-none" value="{{ $categoria->nome }}" required placeholder="Fertilizantes / Venda de Soja">
            </div>

            <div class="mb-6">
                <label for="tipo_receita_despesa" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Lançamento</label>
                <select name="tipo_receita_despesa" id="tipo_receita_despesa" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-[#059669] focus:border-[#059669] px-4 py-3 transition-colors outline-none" required>
                    <option value="custo" {{ $categoria->tipo_receita_despesa == 'custo' ? 'selected' : '' }}>Despesa</option>
                    <option value="receita" {{ $categoria->tipo_receita_despesa == 'receita' ? 'selected' : '' }}>Receita</option>
                </select>
            </div>

            <div class="pt-2 flex items-center gap-3">
                <button type="submit" class="px-6 py-2.5 bg-[#059669] text-white font-semibold rounded-xl hover:bg-[#047857] transition-colors shadow-sm">
                    Salvar Alterações
                </button>
                <a href="{{ route('categorias.index') }}" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors shadow-sm">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

@endsection