<section>
    <header>
        <h2 class="text-lg font-semibold text-gray-900 border-b border-gray-100 pb-3">Informações do Perfil</h2>
        <p class="mt-4 text-sm text-gray-500">
            Atualize as informações de perfil e endereço de e-mail da sua conta.
        </p>
    </header>

    <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST" class="mt-6 space-y-5">
        @csrf
        @method('PATCH')
        
        <div>
            <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">Nome Completo</label>
            <input type="text" name="nome" id="nome" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-slate-500 focus:border-slate-500 px-4 py-3 transition-colors outline-none" value="{{ Auth::user()->nome }}" required placeholder="Lucas Cardoso Alves">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email (Login)</label>
            <input type="email" name="email" id="email" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-slate-500 focus:border-slate-500 px-4 py-3 transition-colors outline-none" value="{{ Auth::user()->email }}" required placeholder="email@email.com">
        </div>
        
        <div class="flex flex-col sm:flex-row gap-5">
            <div class="flex-1">
                <label for="cpf_cnpj" class="block text-sm font-medium text-gray-700 mb-2">CPF / CNPJ</label>
                <input type="text" name="cpf_cnpj" id="cpf_cnpj" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-slate-500 focus:border-slate-500 px-4 py-3 transition-colors outline-none" value="{{ Auth::user()->cpf_cnpj }}" required placeholder="000.000.000-00">
            </div>
            <div class="flex-1">
                <label for="telefone" class="block text-sm font-medium text-gray-700 mb-2">Telefone</label>
                <input type="text" name="telefone" id="telefone" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-slate-500 focus:border-slate-500 px-4 py-3 transition-colors outline-none" value="{{ Auth::user()->telefone }}" placeholder="(00) 00000-0000">
            </div>
        </div>

        <div>
            <label for="propriedade" class="block text-sm font-medium text-gray-700 mb-2">Nome da Propriedade</label>
            <input type="text" name="propriedade" id="propriedade" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-slate-500 focus:border-slate-500 px-4 py-3 transition-colors outline-none" value="{{ Auth::user()->propriedade }}" placeholder="Fazenda Esperança">
        </div>

        <div>
            <label for="cultura_principal" class="block text-sm font-medium text-gray-700 mb-2">Cultura Principal</label>
            <input type="text" name="cultura_principal" id="cultura_principal" class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-slate-500 focus:border-slate-500 px-4 py-3 transition-colors outline-none" value="{{ Auth::user()->cultura_principal }}" placeholder="Arroz / Milho / Soja">
        </div>

        <div class="pt-2 flex justify-end">
            <button type="submit" class="px-6 py-2.5 bg-slate-800 text-white font-semibold rounded-xl hover:bg-slate-900 transition-colors shadow-sm">
                Salvar Alterações
            </button>
        </div>
    </form>
</section>