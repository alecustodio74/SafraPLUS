@extends('layouts.app')

@section('content')
<div class="container my-3 py-5">
    <div class="row justify-content-center">
        <div class="col-md-11">

            @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
            @endif

            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header text-center bg-success text-white">
                    <h1 class="mb-0 h3 fw-bold">Gerenciamento de Safras</h1>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{ route('safras.create') }}" class="btn btn-primary">Nova Safra</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Cultura</th>
                                    @can('is-admin')
                                        <th>Produtor</th>
                                    @endcan
                                    <th>Área (ha)</th>
                                    <th>Localização</th>
                                    <th>Início</th>
                                    <th>Fim</th>
                                    <th style="width: 150px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($safras as $safra)
                                <tr>
                                    <td>{{ $safra->cultura }}</td>
                                    @can('is-admin')
                                        <td>{{ $safra->produtor->nome ?? 'N/A' }}</td>
                                    @endcan
                                    <td>{{ number_format($safra->area_plantada, 2, ',', '.') }}</td>
                                    <td>{{ $safra->localizacao }}</td>
                                    <td>{{ \Carbon\Carbon::parse($safra->data_inicio)->format('d/m/Y') }}</td>
                                    <td>{{ $safra->data_fim ? \Carbon\Carbon::parse($safra->data_fim)->format('d/m/Y') : 'Em Andamento' }}</td>
                                    <td>
                                        <a href="{{ route('safras.edit', $safra->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                        <form action="{{ route('safras.destroy', $safra->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta safra e todos os seus lançamentos?')">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="@can('is-admin') 7 @else 6 @endcan" class="text-center">Nenhuma safra cadastrada.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <a href="{{ route('painel') }}" class="btn btn-secondary">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection