<section>
    <header>
        <h2 class="h5 fw-bold text-dark">
            Informações do Perfil
        </h2>
        <p class="mt-1 text-muted">
            Atualize as informações de perfil e endereço de e-mail da sua conta.
        </p>
    </header>

    <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST" class="mt-4">
        @csrf
        @method('PATCH')
        
        <div class="mb-3">
            <label for="nome" class="form-label">Nome Completo</label>
            <input type="text" name="nome" id="nome" class="form-control" value="{{ Auth::user()->nome }}" required placeholder="Lucas Cardoso Alves">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email (Login)</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ Auth::user()->email }}" required placeholder="email@email.com">
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="cpf_cnpj" class="form-label">CPF / CNPJ (apenas númeors)</label>
                <input type="text" name="cpf_cnpj" id="cpf_cnpj" class="form-control" value="{{ Auth::user()->cpf_cnpj }}" required placeholder="***.***.***-**">
            </div>
            <div class="col-md-6 mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" name="telefone" id="telefone" class="form-control" value="{{ Auth::user()->telefone }}" placeholder="18 993565934">
            </div>
        </div>

        <div class="mb-3">
            <label for="propriedade" class="form-label">Nome da Propriedade</label>
            <input type="text" name="propriedade" id="propriedade" class="form-control" value="{{ Auth::user()->propriedade }}" placeholder="Fazenda Colorado">
        </div>

        <div class="mb-3">
            <label for="cultura_principal" class="form-label">Cultura Principal</label>
            <input type="text" name="cultura_principal" id="cultura_principal" class="form-control" value="{{ Auth::user()->cultura_principal }}" placeholder="Arroz / Milho / Soja">
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success">Salvar Alterações</button>
        </div>
    </form>
</section>