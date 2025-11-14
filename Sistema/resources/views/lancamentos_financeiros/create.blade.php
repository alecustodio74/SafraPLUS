@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-custom">
                <div class="card-header bg-success text-white text-center fw-bold fs-4">
                    Novo Lançamento Financeiro
                </div>

                <div class="card-body">
                    <form action="{{ route('lancamentos-financeiros.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="safra_id" class="form-label">Safra</label>
                            <select name="safra_id" id="safra_id" class="form-select @error('safra_id') is-invalid @enderror" required>
                                <option value="">Selecione a safra</option>
                                @foreach($safras as $safra)
                                    <option value="{{ $safra->id }}" {{ old('safra_id') == $safra->id ? 'selected' : '' }}>
                                        {{ $safra->cultura }} ({{ $safra->data_inicio }})
                                    </option>
                                @endforeach
                            </select>
                            @error('safra_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="categoria_id" class="form-label">Categoria</label>
                            <select name="categoria_id" id="categoria_id" class="form-select @error('categoria_id') is-invalid @enderror" required>
                                <option value="">Selecione a categoria</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                        {{ $categoria->nome }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoria_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tipo_receita_custo" class="form-label">Tipo</label>
                            <select name="tipo_receita_custo" id="tipo_receita_custo" class="form-select @error('tipo_receita_custo') is-invalid @enderror" required>
                                <option value="">Selecione o tipo</option>
                                <option value="receita" {{ old('tipo_receita_custo') == 'receita' ? 'selected' : '' }}>Receita</option>
                                <option value="custo" {{ old('tipo_receita_custo') == 'custo' ? 'selected' : '' }}>Despesa</option>
                            </select>
                            @error('tipo_receita_custo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <input type="text" name="descricao" id="descricao" class="form-control @error('descricao') is-invalid @enderror" value="{{ old('descricao') }}" required placeholder="Sementes de Milho">
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="valor_total" class="form-label">Valor Total</label>
                            <input type="number" step="0.01" name="valor_total" id="valor_total" class="form-control @error('valor_total') is-invalid @enderror" value="{{ old('valor_total') }}" required placeholder="R$ 2500,00">
                            @error('valor_total')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="data_lancamento" class="form-label">Data</label>
                            <input type="date" name="data_lancamento" id="data_lancamento" class="form-control @error('data_lancamento') is-invalid @enderror" value="{{ old('data_lancamento', date('Y-m-d')) }}" required>
                            @error('data_lancamento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('lancamentos-financeiros.index') }}" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-success">Salvar Lançamento</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection