@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-custom">
                <div class="card-header bg-success text-white text-center fw-bold fs-4">
                    Novo Insumo
                </div>

                <div class="card-body">
                    <form action="{{ route('insumos.store') }}" method="POST">
                        @csrf

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

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome do Insumo</label>
                            <input type="text" name="nome" id="nome" class="form-control" placeholder="Semente de Soja / Fertilizante NPK" required>
                        </div>

                        <div class="mb-3">
                            <label for="estoque_atual" class="form-label">Estoque Inicial (Opcional)</label>
                            <input type="number" step="0.01" name="estoque_atual" id="estoque_atual" class="form-control" value="0.00" placeholder="50">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('insumos.index') }}" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-success">Salvar Insumo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection