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
                    <h1 class="mb-0 h3 fw-bold">Lançamentos Financeiros</h1>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{ route('lancamentos-financeiros.create') }}" class="btn btn-primary">Novo Lançamento</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Data</th>
                                    <th>Descrição</th>
                                    <th>Safra</th>
                                    <th>Categoria</th>
                                    <th>Tipo</th>
                                    <th>Valor</th>
                                    @can('is-admin')
                                    <th>Produtor</th>
                                    @endcan
                                    <th style="width: 150px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lancamentos as $lancamento)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($lancamento->data)->format('d/m/Y') }}</td>
                                    <td>{{ $lancamento->descricao }}</td>
                                    <td>{{ $lancamento->safra->cultura ?? 'N/A' }}</td>
                                    <td>{{ $lancamento->categoria->nome ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge {{ $lancamento->tipo_receita_custo == 'receita' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($lancamento->tipo_receita_custo) }}
                                        </span>
                                    </td>
                                    <td>R$ {{ number_format($lancamento->valor_total, 2, ',', '.') }}</td>
                                    @can('is-admin')
                                    <td>{{ $lancamento->safra->produtor->nome ?? 'N/A' }}</td>
                                    @endcan
                                    <td>
                                        <a href="{{ route('lancamentos-financeiros.edit', $lancamento->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                        <form action="{{ route('lancamentos-financeiros.destroy', $lancamento->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este lançamento?')">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="@can('is-admin') 8 @else 7 @endcan" class="text-center">Nenhum lançamento cadastrado.</td>
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