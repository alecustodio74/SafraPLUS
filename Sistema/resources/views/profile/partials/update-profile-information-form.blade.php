<section>
    <header>
        <h2 class="text-xl font-bold text-slate-800">
            Informações do Perfil
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            Atualize as informações de perfil e endereço de e-mail da sua conta.
        </p>
    </header>

    <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST" class="mt-6 space-y-6">
        @csrf
        @method('PATCH')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nome" class="block text-sm font-medium text-slate-700 mb-1">Nome Completo</label>
                <input type="text" name="nome" id="nome" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" value="{{ Auth::user()->nome }}" required placeholder="Lucas Cardoso Alves">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email (Login)</label>
                <input type="email" name="email" id="email" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" value="{{ Auth::user()->email }}" required placeholder="email@email.com">
            </div>
            
            <div>
                <label for="cpf_cnpj" class="block text-sm font-medium text-slate-700 mb-1">CPF / CNPJ</label>
                <input type="text" name="cpf_cnpj" id="cpf_cnpj" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" value="{{ Auth::user()->cpf_cnpj }}" required placeholder="Apenas números">
            </div>

            <div>
                <label for="telefone" class="block text-sm font-medium text-slate-700 mb-1">Telefone</label>
                <input type="text" name="telefone" id="telefone" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" value="{{ Auth::user()->telefone }}" placeholder="(00) 00000-0000">
            </div>

            <div class="md:col-span-2">
                <label for="propriedade" class="block text-sm font-medium text-slate-700 mb-1">Nome da Propriedade</label>
                <input type="text" name="propriedade" id="propriedade" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" value="{{ Auth::user()->propriedade }}" placeholder="Fazenda Colorado">
            </div>

            <div class="md:col-span-2">
                <label for="cultura_principal" class="block text-sm font-medium text-slate-700 mb-1">Cultura Principal</label>
                <input type="text" name="cultura_principal" id="cultura_principal" class="w-full border-slate-300 bg-slate-50 text-slate-900 focus:bg-white focus:border-primary-500 focus:ring-primary-500 rounded-xl shadow-sm transition-colors px-4 py-2.5" value="{{ Auth::user()->cultura_principal }}" placeholder="Arroz / Milho / Soja">
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
            <button type="submit" class="inline-flex justify-center items-center px-6 py-2.5 bg-primary-600 border border-transparent rounded-xl font-bold text-sm text-white shadow-md shadow-primary-500/30 hover:bg-primary-700 hover:shadow-lg hover:shadow-primary-600/40 focus:bg-primary-700 active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-200">
                Salvar Alterações
            </button>
            
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-medium">Salvo com sucesso.</p>
            @endif
        </div>
    </form>
</section>