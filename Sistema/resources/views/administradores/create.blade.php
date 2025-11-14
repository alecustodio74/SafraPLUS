@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-custom">
                <div class="card-header text-center bg-success text-white fw-bold fs-4">
                    Cadastrar Novo Administrador
                </div>

                <div class="card-body">
                    <form action="{{ route('administradores.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome Completo</label>
                            <input type="text" name="nome" id="nome" class="form-control" required placeholder="Carlos Albuquerque Dias">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email (Login)</label>
                            <input type="email" name="email" id="email" class="form-control" required placeholder="email@email.com">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" name="password" id="password" class="form-control" required placeholder="********">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cpf_cnpj" class="form-label">CPF / CNPJ (apenas número)</label>
                                <input type="text" name="cpf_cnpj" id="cpf_cnpj" class="form-control" required placeholder="***.***.***-**">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="text" name="telefone" id="telefone" class="form-control" placeholder="18 994244563">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('administradores.index') }}" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-success">Salvar Administrador</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection