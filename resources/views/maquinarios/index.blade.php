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
                    <h1 class="mb-0 h3 fw-bold">Cadastro de Maquinários</h1>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{ route('maquinarios.create') }}" class="btn btn-primary">Novo Maquinário</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nome</th>
                                    <th>Marca/Modelo</th>
                                    <th>Descrição</th>
                                    <th>Ano</th>
                                    <th>Custo/Hora</th>
                                    @can('is-admin')
                                        <th>Produtor</th>
                                    @endcan
                                    <th style="width: 150px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($maquinarios as $maquinario)
                                <tr>
                                    <td>{{ $maquinario->nome }}</td>
                                    <td>{{ $maquinario->marca }} / {{ $maquinario->modelo }}</td>
                                    <td>{{ $maquinario->descricao_atividade }}</td>
                                    <td>{{ $maquinario->ano }}</td>
                                    <td>R$ {{ number_format($maquinario->custo_hora, 2, ',', '.') }}</td>
                                    @can('is-admin')
                                        <td>{{ $maquinario->produtor->nome ?? 'N/A' }}</td>
                                    @endcan
                                    <td>
                                        <a href="{{ route('maquinarios.edit', $maquinario->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                        <form action="{{ route('maquinarios.destroy', $maquinario->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este maquinário?')">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    {{-- Colspan atualizado de 6/5 para 7/6 --}}
                                    <td colspan="@can('is-admin') 7 @else 6 @endcan" class="text-center">Nenhum maquinário cadastrado.</td>
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