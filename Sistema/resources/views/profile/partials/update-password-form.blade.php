<section>
    <header>
        <h2 class="text-xl font-bold text-slate-800">
            Alterar Senha
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            Garanta que sua conta esteja usando uma senha longa e segura.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update_password') }}" class="mt-6 space-y-6 max-w-xl">
        @csrf
        @method('put')

        <div>
            <label for="current_password" class="block text-sm font-medium text-slate-700 mb-1">Senha Atual</label>
            <input type="password" name="current_password" id="current_password" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-slate-500 focus:ring-slate-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" required placeholder="********">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Nova Senha</label>
            <input type="password" name="password" id="password" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-slate-500 focus:ring-slate-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" required placeholder="********">
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Confirme a Nova Senha</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-slate-500 focus:ring-slate-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" required placeholder="********">
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
            <button type="submit" class="inline-flex justify-center items-center px-6 py-2.5 bg-slate-800 border border-transparent rounded-xl font-bold text-sm text-white shadow-md hover:bg-slate-700 focus:bg-slate-700 active:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition-all duration-200">
                Salvar Nova Senha
            </button>
            
            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-medium">Senha atualizada.</p>
            @endif
        </div>
    </form>
</section>