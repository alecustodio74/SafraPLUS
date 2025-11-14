<section class="space-y-6">
    <header>
        <h2 class="h5 fw-bold text-danger">
            Excluir Conta
        </h2>

        <p class="mt-1 text-muted">
            Depois que sua conta for excluída, todos os seus recursos e dados (incluindo safras, finanças, etc.) serão permanentemente apagados.
        </p>
    </header>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        Excluir Minha Conta
    </button>

    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title text-danger fw-bold" id="modalLabel">Tem certeza que deseja excluir sua conta?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p class="text-muted">
                            Por favor, digite sua senha para confirmar que você deseja excluir permanentemente sua conta. Esta ação não pode ser desfeita.
                        </p>

                        <div class="mt-3">
                            <label for="password_delete" class="form-label">Senha</label>
                            <input id="password_delete" name="password" type="password" class="form-control" placeholder="Sua senha" required>
                            
                            @error('password', 'userDeletion')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Excluir Conta Permanentemente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>