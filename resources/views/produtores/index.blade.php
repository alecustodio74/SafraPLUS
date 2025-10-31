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
                    <h1 class="mb-0 h3 fw-bold">Produtores</h1>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <a href="{{ route('produtores.create') }}" class="btn btn-primary">Novo Produtor</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>CPF/CNPJ</th>
                                    <th>Propriedade</th>
                                    <th>Tipo de Usuário</th>
                                    <th style="width: 150px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produtores as $produtor)
                                <tr>
                                    <td>{{ $produtor->nome }}</td>
                                    <td>{{ $produtor->email }}</td>
                                    <td>{{ $produtor->cpf_cnpj }}</td>
                                    <td>{{ $produtor->propriedade }}</td>
                                    <td>
                                        <span class="badge {{ $produtor->role == 'admin' ? 'bg-danger' : 'bg-success' }}">
                                            {{ ucfirst($produtor->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('produtores.edit', $produtor->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                        <form action="{{ route('produtores.destroy', $produtor->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este produtor?')">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Nenhum produtor cadastrado.</td>
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