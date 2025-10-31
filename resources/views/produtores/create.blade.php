@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-custom">
                <div class="card-header text-center bg-success text-white fw-bold fs-4">
                    Cadastrar Novo Produtor
                </div>

                <div class="card-body">
                    <form action="{{ route('produtores.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome Completo</label>
                            <input type="text" name="nome" id="nome" class="form-control" required placeholder="Henrique Cruz de Lima">
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
                                <label for="cpf_cnpj" class="form-label">CPF / CNPJ (apenas números)</label>
                                <input type="text" name="cpf_cnpj" id="cpf_cnpj" class="form-control" required placeholder="***.***.***-**">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="text" name="telefone" id="telefone" class="form-control" placeholder="18 938485461">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="propriedade" class="form-label">Nome da Propriedade</label>
                            <input type="text" name="propriedade" id="propriedade" class="form-control" placeholder="Fazenda Colorado">
                        </div>

                        <div class="mb-3">
                            <label for="cultura_principal" class="form-label">Cultura Principal</label>
                            <input type="text" name="cultura_principal" id="cultura_principal" class="form-control" placeholder="Arroz / Soja / Milho ">
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Tipo de Usuário</label>
                            <select name="role" id="role" class="form-select" required placeholder="Selecione o tipo de usuário">
                                <option value="produtor">Produtor</option>
                                <option value="admin">Administrador</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('produtores.index') }}" class="btn btn-secondary">Voltar</a>
                            <button type="submit" class="btn btn-success">Salvar Produtor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection