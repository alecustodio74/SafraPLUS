@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-custom">
                <div class="card-header bg-success text-white text-center fw-bold fs-4">
                    Novo Maquinário
                </div>

                <div class="card-body">
                    <form action="{{ route('maquinarios.store') }}" method="POST">
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
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" name="nome" id="nome" class="form-control" placeholder="Trator / Colheitadeira" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="marca" class="form-label">Marca</label>
                                <input type="text" name="marca" id="marca" class="form-control" placeholder="John Deere">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modelo" class="form-label">Modelo</label>
                                <input type="text" name="modelo" id="modelo" class="form-control" placeholder="6170M">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ano" class="form-label">Ano</label>
                                <input type="number" name="ano" id="ano" class="form-control" placeholder="2023">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="custo_hora" class="form-label">Custo/Hora (Opcional)</label>
                                <input type="number" step="0.01" name="custo_hora" id="custo_hora" class="form-control" placeholder="R$ 150,00">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descricao_atividade" class="form-label">Descrição da Atividade (Opcional)</label>
                            <textarea name="descricao_atividade" id="descricao_atividade" class="form-control" rows="3" placeholder="Arar terra para plantação"></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('maquinarios.index') }}" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-success">Salvar Maquinário</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection