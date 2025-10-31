@extends('layouts.app')

@section('content')
<div class="container my-3 py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">

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
                    <h1 class="mb-0 h3 fw-bold">Cadastro de Insumos</h1>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{ route('insumos.create') }}" class="btn btn-primary">Novo Insumo</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nome do Insumo</th>
                                    <th>Estoque Atual</th>
                                    @can('is-admin')
                                        <th>Produtor</th>
                                    @endcan
                                    <th style="width: 150px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($insumos as $insumo)
                                <tr>
                                    <td>{{ $insumo->nome }}</td>
                                    <td>{{ number_format($insumo->estoque_atual, 2, ',', '.') }}</td>
                                    @can('is-admin')
                                        <td>{{ $insumo->produtor->nome ?? 'N/A' }}</td>
                                    @endcan
                                    <td>
                                        <a href="{{ route('insumos.edit', $insumo->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                        <form action="{{ route('insumos.destroy', $insumo->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este insumo?')">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="@can('is-admin') 4 @else 3 @endcan" class="text-center">Nenhum insumo cadastrado.</td>
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