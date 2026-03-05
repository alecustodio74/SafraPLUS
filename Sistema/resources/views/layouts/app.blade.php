<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SafraPLUS') }}</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full font-sans antialiased text-gray-900 overflow-hidden flex bg-gray-50">

    <!-- Sidebar -->
    <aside class="w-64 bg-[#111827] text-gray-300 flex flex-col h-full shrink-0 transition-all duration-300">
        <!-- Logo -->
        <div class="h-20 flex items-center px-6 border-b border-gray-800">
            <a href="{{ route('painel') }}" class="block">
                <img src="{{ asset('images/logo.png') }}" class="h-8 w-auto filter brightness-0 invert" style="height: 32px; width: auto; filter: brightness(0) invert(1);" alt="SafraPLUS">
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-6">
            
            <!-- Painel -->
            <div>
                <a href="{{ route('painel') }}" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('painel') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white transition-colors' }}">
                    <svg class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Painel
                </a>
            </div>

            <!-- GESTÃO DE USUÁRIOS -->
            @can('is-admin')
            <div>
                <h3 class="px-3 text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Gestão de Usuários</h3>
                <div class="space-y-1">
                    <a href="{{ route('administradores.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('administradores.*') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white transition-colors' }}">
                        <svg class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Administradores
                    </a>
                    <a href="{{ route('produtores.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('produtores.*') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white transition-colors' }}">
                        <svg class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Produtores
                    </a>
                </div>
            </div>
            @endcan

            <!-- CADASTROS BASE -->
            <div>
                <h3 class="px-3 text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Cadastros Base</h3>
                <div class="space-y-1">
                    <a href="{{ route('categorias.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('categorias.*') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white transition-colors' }}">
                        <svg class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        Categorias
                    </a>
                    <a href="{{ route('insumos.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('insumos.*') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white transition-colors' }}">
                        <svg class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        Insumos
                    </a>
                    <a href="{{ route('maquinarios.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('maquinarios.*') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white transition-colors' }}">
                        <svg class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Maquinários
                    </a>
                    <a href="{{ route('mao-de-obra.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('mao-de-obra.*') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white transition-colors' }}">
                        <svg class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Mão de Obra
                    </a>
                </div>
            </div>

            <!-- OPERAÇÕES & FINANÇAS -->
            <div>
                <h3 class="px-3 text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Operações & Finanças</h3>
                <div class="space-y-1">
                    <a href="{{ route('safras.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('safras.*') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white transition-colors' }}">
                        <svg class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Gerenciar Safras
                    </a>
                    <a href="{{ route('movimentacoes-estoque.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('movimentacoes-estoque.*') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white transition-colors' }}">
                        <svg class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Estoque
                    </a>
                    <a href="{{ route('custos-operacionais.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('custos-operacionais.*') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white transition-colors' }}">
                        <svg class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Custos Operacionais
                    </a>
                    <a href="{{ route('lancamentos-financeiros.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('lancamentos-financeiros.*') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white transition-colors' }}">
                        <svg class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"/></svg>
                        Financeiro
                    </a>
                </div>
            </div>

            <!-- RELATÓRIOS -->
            <div class="mt-4 pb-12">
                <a href="{{ route('relatorios.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('relatorios.*') ? 'bg-[#1f2937] text-white' : 'hover:bg-[#1f2937] hover:text-white transition-colors' }}">
                    <svg class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Relatórios
                </a>
            </div>

        </nav>
    </aside>

    <!-- Main Content wrapper -->
    <div class="flex-1 flex flex-col h-full overflow-hidden relative">
        
        <!-- Header -->
        <!-- Add x-data for dropdown alpinejs if preferred, or pure css. Here we use group-hover which is CSS only -->
        <header class="bg-white px-8 h-20 flex items-center justify-between shadow-sm z-10 shrink-0 border-b border-gray-100">
            <!-- Title -->
            <div class="flex-1 flex items-center">
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">
                    @yield('header_title', 'Dashboard')
                </h1>
            </div>
            
            <!-- User Menu -->
            <div class="flex items-center space-x-6">
                
                <!-- Separator -->
                <div class="h-8 w-px bg-gray-200"></div>
                
                <!-- Profile dropdown -->
                <div class="relative group">
                    <button type="button" class="flex items-center gap-3 focus:outline-none rounded-full py-1 pr-2 hover:bg-gray-50 transition-colors">
                        @php
                            $nomeCompleto = Auth::user()->nome ?? Auth::user()->name ?? 'Usuário';
                            $primeiraLetra = strtoupper(substr($nomeCompleto, 0, 1));
                            $primeiroNome = explode(' ', trim($nomeCompleto))[0];
                        @endphp
                        
                        <div class="h-10 w-10 rounded-full bg-[#10b981]/10 text-[#059669] border border-[#34d399]/30 flex items-center justify-center font-bold text-lg shadow-sm">
                            {{ $primeiraLetra }}
                        </div>
                        <div class="hidden md:flex flex-col text-left">
                            <span class="block text-sm font-semibold text-gray-700 leading-tight">{{ $primeiroNome }}</span>
                            <span class="block text-xs text-gray-400 font-medium">Painel de Controle</span>
                        </div>
                        <svg class="h-4 w-4 text-gray-400 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    
                    <!-- Dropdown menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 transform origin-top-right scale-95 group-hover:scale-100">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-green-600 transition-colors">Perfil</a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-red-600 transition-colors">Sair do Sistema</button>
                        </form>
                    </div>
                </div>

            </div>
        </header>
        
        <!-- Content Area -->
        <main class="flex-1 overflow-y-auto p-8 bg-gray-50">
            @yield('content')
        </main>

    </div>
    
    @yield('scripts')
</body>
</html>