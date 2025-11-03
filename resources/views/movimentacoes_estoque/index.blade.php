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
                    <h1 class="mb-0 h3 fw-bold">Movimentações de Estoque</h1>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{ route('movimentacoes-estoque.create') }}" class="btn btn-primary">Nova Movimentação</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Data</th>
                                    <th>Tipo</th>
                                    <th>Insumo</th>
                                    <th>Qtd</th>
                                    <th>Safra (Saída)</th>
                                    @can('is-admin')
                                    <th>Produtor</th>
                                    @endcan
                                    <th style="width: 150px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($movimentacoes as $movimentacao)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($movimentacao->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge {{ $movimentacao->tipo_movimentacao == 'entrada' ? 'bg-primary' : 'bg-secondary' }}">
                                            {{ ucfirst($movimentacao->tipo_movimentacao) }}
                                        </span>
                                    </td>
                                    <td>{{ $movimentacao->insumo->nome ?? 'N/A' }}</td>
                                    <td>{{ $movimentacao->quantidade }}</td>
                                    <td>{{ $movimentacao->safra->cultura ?? 'N/A' }}</td>
                                    @can('is-admin')
                                    <td>{{ $movimentacao->insumo->produtor->nome ?? 'N/A' }}</td>
                                    @endcan
                                    <td>
                                        <a href="{{ route('movimentacoes-estoque.edit', $movimentacao->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                        <form action="{{ route('movimentacoes-estoque.destroy', $movimentacao->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta movimentação?')">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="@can('is-admin') 7 @else 6 @endcan" class="text-center">Nenhuma movimentação cadastrada.</td>
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