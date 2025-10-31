@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-custom">
                <div class="card-header bg-success text-white text-center fw-bold fs-4">
                    Nova Categoria
                </div>

                <div class="card-body">
                    <form action="{{ route('categorias.store') }}" method="POST">
                        @csrf

                        {{-- OPÇÂO PARA ADMIN --}}
                        @can('is-admin')
                        <div class="mb-3">
                            <label for="produtor_id" class="form-label">Produtor</label>
                            <select name="produtor_id" id="produtor_id" class="form-select" required>
                                <option value="">Selecione um produtor</option>
                                @foreach($produtores as $produtor)
                                <option value="{{ $produtor->id }}">{{ $produtor->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endcan
                        {{-- FIM DA OPÇÂO DO ADMIN --}}

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome da Categoria</label>
                            <input type="text" name="nome" id="nome" class="form-control" placeholder="Fertilizantes / Venda de Soja" required>
                        </div>

                        <div class="mb-3">
                            <label for="tipo_receita_despesa" class="form-label">Tipo</label>
                            <select name="tipo_receita_despesa" id="tipo_receita_despesa" class="form-select" required>
                                <option value="">Selecione o tipo</option>
                                <option value="custo">Despesa</option>
                                <option value="receita">Receita</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-success">Salvar Categoria</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection