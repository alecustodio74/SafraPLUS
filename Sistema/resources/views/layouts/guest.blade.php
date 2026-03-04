<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-slate-800 bg-surface">
    <div class="min-h-screen flex">
        
        <!-- Left Side: Branding / Visual (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-primary-600 to-primary-900 relative overflow-hidden items-center justify-center p-12">
            <!-- Decorative Elements -->
            <div class="absolute -top-32 -left-32 w-96 h-96 bg-primary-500/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-primary-400/20 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col items-center text-center">
                <a href="/">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SafraPLUS" class="w-48 h-auto mb-8 drop-shadow-xl transition transform hover:scale-105 duration-300">
                </a>
                <h1 class="text-4xl font-display font-bold text-white mb-4">Gestão Inteligente para o Agronegócio</h1>
                <p class="text-primary-100 text-lg max-w-md">Controle suas safras, insumos e finanças com uma plataforma moderna e eficiente.</p>
            </div>
        </div>

        <!-- Right Side: Auth Form -->
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:w-1/2 lg:px-20 xl:px-24 bg-surface relative">
            
            <!-- Mobile Logo (Visible only on small screens) -->
            <div class="flex lg:hidden justify-center mb-8">
                <a href="/">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SafraPLUS" class="w-32 h-auto drop-shadow-md">
                </a>
            </div>

            <div class="mx-auto w-full max-w-sm lg:w-96">
                <!-- Auth Card -->
                <div class="bg-white py-8 px-6 shadow-xl sm:rounded-2xl sm:px-10 border border-slate-100">
                    {{ $slot }}
                </div>
                
                <!-- Footer Info -->
                <p class="mt-8 text-center text-sm text-slate-500">
                    &copy; {{ date('Y') }} SafraPLUS. Todos os direitos reservados.
                </p>
            </div>
        </div>

    </div>
</body>

</html>