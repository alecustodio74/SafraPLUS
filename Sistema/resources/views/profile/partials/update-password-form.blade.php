<section>
    <header>
        <h2 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-3">Alterar Senha</h2>
        <p class="mt-4 text-sm text-gray-500">
            Garanta que sua conta está usando uma senha longa e aleatória para se manter segura.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update_password') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Senha Atual</label>
            <input type="password" name="current_password" id="current_password" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-slate-500 focus:border-slate-500 px-4 py-3 transition-colors outline-none" required placeholder="********">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nova Senha</label>
            <input type="password" name="password" id="password" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-slate-500 focus:border-slate-500 px-4 py-3 transition-colors outline-none" required placeholder="********">
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Nova Senha</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-slate-500 focus:border-slate-500 px-4 py-3 transition-colors outline-none" required placeholder="********">
        </div>

        <div class="pt-2 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-slate-800 text-white font-semibold rounded-xl hover:bg-slate-900 transition-colors shadow-sm">
                Atualizar Senha
            </button>
        </div>
    </form>
</section>