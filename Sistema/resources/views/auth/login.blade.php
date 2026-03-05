<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Acesse sua Conta</h2>
        <p class="mt-2 text-sm text-gray-500 text-balance">Bem-vindo(a) de volta! Insira suas credenciais para gerenciar sua propriedade.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">E-mail</label>
            <input id="email" class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-[#059669] focus:ring-[#059669] transition-colors" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="seu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
        </div>

        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block text-sm font-semibold text-gray-700">Senha</label>
                @if (Route::has('password.request'))
                <a class="text-sm font-medium text-[#059669] hover:text-[#047857] transition-colors" href="{{ route('password.request') }}">
                    Esqueceu a senha?
                </a>
                @endif
            </div>
            
            <input id="password" class="block w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-[#059669] focus:ring-[#059669] transition-colors"
                type="password"
                name="password"
                required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
        </div>

        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-[#059669] focus:ring-[#059669]" name="remember">
            <label for="remember_me" class="ml-2 block text-sm text-gray-700">Manter conectado</label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-[#059669] hover:bg-[#047857] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#059669] transition-colors">
                Entrar no Sistema
            </button>
        </div>
        
        @if (Route::has('register'))
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Ainda não tem uma conta? 
                <a href="{{ route('register') }}" class="font-semibold text-[#059669] hover:text-[#047857] transition-colors">Criar conta</a>
            </p>
        </div>
        @endif
    </form>
</x-guest-layout>