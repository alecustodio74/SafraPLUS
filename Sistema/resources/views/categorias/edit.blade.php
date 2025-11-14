@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-custom">
                <div class="card-header bg-success text-white text-center fw-bold fs-4">
                    Editar Categoria
                </div>

                <div class="card-body">
                    <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @can('is-admin')
                        <div class="mb-3">
                            <label for="produtor_id" class="form-label">Produtor</label>
                            <select name="produtor_id" id="produtor_id" class="form-select" required>
                                <option value="">Selecione um produtor</option>
                                @foreach($produtores as $produtor)
                                <option value="{{ $produtor->id }}" {{ $categoria->produtor_id == $produtor->id ? 'selected' : '' }}>
                                    {{ $produtor->nome }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @endcan

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome da Categoria</label>
                            <input type="text" name="nome" id="nome" class="form-control" value="{{ $categoria->nome }}" required placeholder="Fertilizantes">
                        </div>

                        <div class="mb-3">
                            <label for="tipo_receita_despesa" class="form-label">Tipo</label>
                            <select name="tipo_receita_despesa" id="tipo_receita_despesa" class="form-select" required>
                                <option value="custo" {{ $categoria->tipo_receita_despesa == 'custo' ? 'selected' : '' }}>Despesa</option>
                                <option value="receita" {{ $categoria->tipo_receita_despesa == 'receita' ? 'selected' : '' }}>Receita</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-success">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection