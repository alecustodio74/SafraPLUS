<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SafraPLUS') }}</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased h-screen overflow-hidden bg-white">
    <div class="flex h-screen w-full">
        
        <!-- Lado Esquerdo: Banner Agro -->
        <div class="hidden lg:flex lg:w-1/2 bg-[#059669] relative overflow-hidden items-center justify-center">
            <div class="absolute inset-0 bg-gradient-to-br from-[#064e3b]/80 to-[#059669]/60 z-10"></div>
            <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-60" alt="Campos de Plantação">
            
            <div class="relative z-20 p-12 text-white w-full max-w-xl">
                <h1 class="text-5xl font-black mb-6 tracking-tight drop-shadow-md">Gestão Inteligente<br />Para o Campo.</h1>
                <p class="text-xl text-green-50/90 font-medium leading-relaxed drop-shadow-sm">Acompanhe suas safras, gerencie seus custos e maximize a lucratividade da sua fazenda através do SafraPLUS.</p>
                
                <div class="mt-12 flex items-center gap-4">
                    <div class="w-12 h-1 bg-green-400 rounded-full"></div>
                    <div class="w-4 h-1 bg-green-400/40 rounded-full"></div>
                    <div class="w-4 h-1 bg-green-400/40 rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Lado Direito: Formulários (Login/Registro) -->
        <div class="w-full lg:w-1/2 flex flex-col p-8 sm:p-12 lg:p-20 relative overflow-y-auto">
            <div class="flex-[0.4] sm:flex-1"></div>
            <div class="w-full max-w-sm mx-auto flex-none py-8">
                <!-- Logo Topo -->
                <div class="mb-10 text-center sm:text-left">
                    <a href="/" class="inline-block">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo SafraPLUS" class="h-10 w-auto" style="height: 40px; width: auto;">
                    </a>
                </div>

                <!-- O slot de conteúdo (o form em si) vai aqui -->
                {{ $slot }}
                
            </div>
            <div class="flex-1"></div>
        </div>
    </div>
</body>

</html>