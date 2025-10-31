<section>
    <header>
        <h2 class="h5 fw-bold text-danger">
            Alterar Senha
        </h2>
        <p class="mt-1 text-muted">
            Garanta que sua conta está usando uma senha longa e aleatória para se manter segura.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update_password') }}" class="mt-4">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="current_password" class="form-label">Senha Atual</label>
            <input type="password" name="current_password" id="current_password" class="form-control" required placeholder="********">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Nova Senha</label>
            <input type="password" name="password" id="password" class="form-control" required placeholder="********">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirme a Nova Senha</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="********">
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-danger">Salvar Senha</button>
        </div>
    </form>
</section>