@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-custom">
                <div class="card-header bg-success text-white text-center fw-bold fs-4">
                    Editar Lançamento Financeiro
                </div>

                <div class="card-body">
                    <form action="{{ route('lancamentos-financeiros.update', $lancamento->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="safra_id" class="form-label">Associar à Safra</label>
                            <select name="safra_id" id="safra_id" class="form-select" required>
                                <option value="">Selecione uma safra</option>
                                @foreach($safras as $safra)
                                    <option value="{{ $safra->id }}" {{ $lancamento->safra_id == $safra->id ? 'selected' : '' }}>
                                        {{ $safra->cultura }} (Início: {{ $safra->data_inicio }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="categoria_id" class="form-label">Categoria</label>
                            <select name="categoria_id" id="categoria_id" class="form-select" required>
                                <option value="">Selecione uma categoria</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ $lancamento->categoria_id == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nome }} ({{ $categoria->tipo_receita_despesa }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <input type="text" name="descricao" id="descricao" class="form-control" value="{{ $lancamento->descricao }}" required placeholder="Semente de Milho">
                        </div>
                        
                        <div class="mb-3">
                            <label for="data" class="form-label">Data</label>
                            <input type="date" name="data" id="data" class="form-control" value="{{ $lancamento->data }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="valor_total" class="form-label">Valor Total</label>
                            <input type="number" step="0.01" name="valor_total" id="valor_total" class="form-control" value="{{ $lancamento->valor_total }}" required placeholder="R$ 2500,00">
                        </div>

                        <div class="mb-3">
                            <label for="tipo_receita_custo" class="form-label">Tipo</label>
                            <select name="tipo_receita_custo" id="tipo_receita_custo" class="form-select" required>
                                <option value="custo" {{ $lancamento->tipo_receita_custo == 'custo' ? 'selected' : '' }}>Despesa</option>
                                <option value="receita" {{ $lancamento->tipo_receita_custo == 'receita' ? 'selected' : '' }}>Receita</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('lancamentos-financeiros.index') }}" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-success">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection