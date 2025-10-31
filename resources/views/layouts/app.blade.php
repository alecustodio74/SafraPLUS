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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .card-custom {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-success {
            background-color: #28a745;
        }

        .card-danger {
            background-color: #dc3545;
        }

        .card-info {
            background-color: #17a2b8;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ route('painel') }}">
                    <a href="painel">
                        <a class="navbar-brand" href="{{ route('painel') }}">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo SafraPLUS" style="width: 80px; height: auto; filter: brightness(0) invert(1);">
                        </a>
                        <!-- o filter permite mudar a cor da imagem de verde para branco -->
                    </a>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse fw-bold" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('painel') }}">Painel</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCadastros" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Cadastros
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownCadastros">
                                @can('is-admin')
                                <li>
                                    <h6 class="dropdown-header">Gestão de Usuários</h6>
                                </li>

                                <li><a class="dropdown-item" href="{{ route('administradores.index') }}">Administradores</a></li>
                                <li><a class="dropdown-item" href="{{ route('produtores.index') }}">Produtores</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                @endcan
                                <li><a class="dropdown-item" href="{{ route('categorias.index') }}">Categorias</a></li>
                                <li><a class="dropdown-item" href="{{ route('insumos.index') }}">Insumos</a></li>
                                <li><a class="dropdown-item" href="{{ route('maquinarios.index') }}">Maquinários</a></li>
                                <li><a class="dropdown-item" href="{{ route('mao-de-obra.index') }}">Mão de Obra</a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownOperacoes" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Operações
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownOperacoes">
                                <li><a class="dropdown-item" href="{{ route('movimentacoes-estoque.index') }}">Estoque</a></li>
                                <li><a class="dropdown-item" href="{{ route('custos-operacionais.index') }}">Custos Operacionais</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('safras.index') }}">Safras</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('lancamentos-financeiros.index') }}">Financeiro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('relatorios.index') }}">Relatórios</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->nome }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUser">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item" type="submit">Sair</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="mt-5">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>