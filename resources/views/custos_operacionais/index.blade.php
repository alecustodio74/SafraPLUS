@extends('layouts.app')

@section('content')
<div class="container my-3 py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">

            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm">
                <div class="card-header text-center bg-success text-white">
                    <h1 class="mb-0 h3 fw-bold">Custos Operacionais</h1>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{ route('custos-operacionais.create') }}" class="btn btn-primary">Novo Custo</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Data</th>
                                    <th>Descrição</th>
                                    <th>Safra</th>
                                    @can('is-admin')
                                    <th>Produtor</th>
                                    @endcan
                                    <th>Valor</th>
                                    <th>Vínculo</th>
                                    <th style="width: 150px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($custos as $custo)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($custo->data)->format('d/m/Y') }}</td>
                                    <td>{{ $custo->descricao }}</td>
                                    <td>{{ $custo->safra->cultura ?? 'N/A' }}</td>
                                    @can('is-admin')
                                    <td>{{ $custo->safra->produtor->nome ?? 'N/A' }}</td>
                                    @endcan
                                    <td>R$ {{ number_format($custo->valor, 2, ',', '.') }}</td>

                                    <td>
                                        @php
                                        $vinculos = [];
                                        if ($custo->maquinario) {
                                        $vinculos[] = $custo->maquinario->nome;
                                        }
                                        if ($custo->maoDeObra) {
                                        // CORREÇÃO AQUI:
                                        $vinculos[] = $custo->maoDeObra->nome_ou_tipo;
                                        }
                                        @endphp

                                        {{ !empty($vinculos) ? implode(' / ', $vinculos) : 'N/A' }}
                                    </td>

                                    <td>
                                        <a href="{{ route('custos-operacionais.edit', $custo->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                        <form action="{{ route('custos-operacionais.destroy', $custo->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este custo?')">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="@can('is-admin') 7 @else 6 @endcan" class="text-center">Nenhum custo operacional cadastrado.</td>
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