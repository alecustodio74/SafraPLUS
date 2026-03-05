<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Crie sua Conta</h2>
        <p class="mt-2 text-sm text-gray-500 text-balance">Junte-se ao SafraPLUS e comece a gerenciar sua propriedade com produtividade e inteligência.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-50 rounded-xl" role="alert">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nome Completo</label>
            <input id="name" class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-[#059669] focus:ring-[#059669] transition-colors" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Ex: Higor Pereira Lima"/>
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-600 text-xs" />
        </div>

        <div>
            <label for="cpf_cnpj" class="block text-sm font-semibold text-gray-700 mb-1">CPF ou CNPJ</label>
            <input id="cpf_cnpj" class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-[#059669] focus:ring-[#059669] transition-colors" type="text" name="cpf_cnpj" :value="old('cpf_cnpj')" required autocomplete="cpf_cnpj" placeholder="Apenas números" />
            <x-input-error :messages="$errors->get('cpf_cnpj')" class="mt-1 text-red-600 text-xs" />
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">E-mail</label>
            <input id="email" class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-[#059669] focus:ring-[#059669] transition-colors" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="seu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-600 text-xs" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="telefone" class="block text-sm font-semibold text-gray-700 mb-1">Telefone</label>
                <input id="telefone" class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-[#059669] focus:ring-[#059669] transition-colors" type="text" name="telefone" :value="old('telefone')" autocomplete="telefone" placeholder="(DD) 99999-9999" />
                <x-input-error :messages="$errors->get('telefone')" class="mt-1 text-red-600 text-xs" />
            </div>

            <div>
                <label for="propriedade" class="block text-sm font-semibold text-gray-700 mb-1">Nome da Propriedade</label>
                <input id="propriedade" class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-[#059669] focus:ring-[#059669] transition-colors" type="text" name="propriedade" :value="old('propriedade')" autocomplete="propriedade" placeholder="Ex: Fazenda Colorado" />
                <x-input-error :messages="$errors->get('propriedade')" class="mt-1 text-red-600 text-xs" />
            </div>
        </div>
        
        <!-- We use hidden to avoid creating more columns, cultura is required but can be general -->
        <div>
            <label for="cultura_principal" class="block text-sm font-semibold text-gray-700 mb-1">Cultura Principal</label>
            <input id="cultura_principal" class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-[#059669] focus:ring-[#059669] transition-colors" type="text" name="cultura_principal" :value="old('cultura_principal')" autocomplete="cultura_principal" placeholder="Ex: Soja / Milho / Trigo"/>
            <x-input-error :messages="$errors->get('cultura_principal')" class="mt-1 text-red-600 text-xs" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Senha</label>
                <input id="password" class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-[#059669] focus:ring-[#059669] transition-colors"
                    type="password" name="password" required autocomplete="new-password" placeholder="••••••••"/>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-600 text-xs" />
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirmar Senha</label>
                <input id="password_confirmation" class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm focus:border-[#059669] focus:ring-[#059669] transition-colors"
                    type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-600 text-xs" />
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-[#059669] hover:bg-[#047857] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#059669] transition-colors">
                Criar Conta
            </button>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Já tem uma conta?
                <a class="font-semibold text-[#059669] hover:text-[#047857] transition-colors" href="{{ route('login') }}">
                    Ir para Login
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>