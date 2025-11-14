@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-custom">
                <div class="card-header bg-success text-white text-center fw-bold fs-4">
                    Nova Safra
                </div>

                <div class="card-body">
                    <form action="{{ route('safras.store') }}" method="POST">
                        @csrf

                        @can('is-admin')
                            <div class="mb-3">
                                <label for="produtor_id" class="form-label">Produtor</label>
                                <select name="produtor_id" id="produtor_id" class="form-select">
                                    <option value="">Selecione um produtor</option>
                                    @foreach($produtores as $produtor)
                                        <option value="{{ $produtor->id }}">{{ $produtor->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endcan

                        <div class="mb-3">
                            <label for="cultura" class="form-label">Cultura</label>
                            <input type="text" name="cultura" id="cultura" class="form-control" required placeholder="Arroz / Soja / Milho">
                        </div>

                        <div class="mb-3">
                            <label for="area_plantada" class="form-label">Área (ha)</label>
                            <input type="number" step="0.01" name="area_plantada" id="area_plantada" class="form-control" placeholder="200">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="data_inicio" class="form-label">Data de Início</label>
                                <input type="date" name="data_inicio" id="data_inicio" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="data_fim" class="form-label">Data de Fim (Opcional)</label>
                                <input type="date" name="data_fim" id="data_fim" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="localizacao" class="form-label">Localização</label>
                            <input type="text" name="localizacao" id="localizacao" class="form-control" placeholder="Rodovia Raposo Tavares, Km 126">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('safras.index') }}" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-success">Salvar Safra</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection