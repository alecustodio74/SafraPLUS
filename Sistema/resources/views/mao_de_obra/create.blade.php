@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-custom">
                <div class="card-header bg-success text-white text-center fw-bold fs-4">
                    Nova Mão de Obra
                </div>

                <div class="card-body">
                    <form action="{{ route('mao-de-obra.store') }}" method="POST">
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
                            <label for="nome_ou_tipo" class="form-label">Nome / Tipo</label>
                            <input type="text" name="nome_ou_tipo" id="nome_ou_tipo" class="form-control" placeholder="Diarista / Tratorista" required>
                        </div>

                        <div class="mb-3">
                            <label for="custo_diario_hora" class="form-label">Custo (Diário/Hora)</label>
                            <input type="number" step="0.01" name="custo_diario_hora" id="custo_diario_hora" class="form-control" placeholder="R$ 150,00">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('mao-de-obra.index') }}" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-success">Salvar Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection