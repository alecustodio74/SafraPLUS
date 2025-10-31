<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <title>{{ config('app.name', 'SafraPLUS') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- CSS específico para os botões (fallback; funciona mesmo sem Tailwind) -->
    <style>
      :root{
        --safra-green: #16A34A;
        --safra-green-dark: #15803d;
        --radius: 0.5rem;
      }

      .auth-buttons{
        display:flex;
        gap:0.6rem;
        justify-content:center;
        margin-top:1rem;
        flex-wrap:wrap;
      }

      .btn{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        padding:0.55rem 1.25rem;
        font-weight:600;
        font-size:1rem;
        border-radius:var(--radius);
        text-decoration:none;
        cursor:pointer;
        border:1px solid transparent;
        transition: transform 180ms cubic-bezier(.4,0,.2,1), box-shadow 180ms ease, background-color 160ms ease, color 160ms ease;
        will-change: transform, box-shadow;
        user-select:none;
      }

      .btn-login{
        background:var(--safra-green);
        color:#fff;
        box-shadow: 0 6px 18px rgba(16,163,74,0.12);
        border-color: rgba(0,0,0,0.04);
      }
      .btn-login:hover,
      .btn-login:focus{
        transform: translateY(-3px) scale(1.02);
        background:var(--safra-green-dark);
        box-shadow: 0 12px 30px rgba(16,163,74,0.18);
        outline: none;
      }

      .btn-register{
        background: #fff;
        color: var(--safra-green);
        border-color: var(--safra-green);
        box-shadow: 0 6px 14px rgba(16,163,74,0.06);
      }
      .btn-register:hover,
      .btn-register:focus{
        transform: translateY(-3px);
        background: rgba(22,163,74,0.06);
        box-shadow: 0 10px 22px rgba(16,163,74,0.12);
        outline: none;
      }

      .btn:focus-visible{
        outline: 3px solid rgba(34,197,94,0.18);
        outline-offset:3px;
      }

      @media (prefers-reduced-motion: reduce){
        .btn{
          transition: none;
        }
        .btn-login:hover, .btn-register:hover, .btn:focus{
          transform: none !important;
        }
      }

      @media (max-width:420px){
        .auth-buttons{ gap:0.4rem; }
        .btn{ padding:0.5rem 0.9rem; font-size:0.95rem; }
      }
    </style>
</head>
<body class="antialiased">
    
    <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="w-full max-w-7xl p-6 lg:p-8 text-center">
            
            <div class="flex justify-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SafraPLUS" style="width: 450px; height: auto;">
            </div>
            <div>    
                <h1 class="flex justify-center text-4xl font-bold mt-8 mb-6 text-gray-800 dark:text-white">
                    Bem vindo a SafraPLUS versão 1.0
                </h1>
            </div>
            
            @if (Route::has('login'))
                <nav class="mt-4">
                    @auth
                        <div class="auth-buttons">
                            <a href="{{ route('painel') }}" role="button" aria-label="Ir para o Painel" class="btn btn-login">
                                Ir para o Painel
                            </a>
                        </div>
                    @else
                        <div class="auth-buttons">
                            <a href="{{ route('login') }}" role="button" aria-label="Entrar" class="btn btn-login">
                                Entrar
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" role="button" aria-label="Cadastre-se" class="btn btn-register">
                                    Cadastre-se
                                </a>
                            @endif
                        </div>
                    @endauth
                </nav>
            @endif

            <div class="mt-8 text-sm text-gray-500 dark:text-gray-400 flex justify-center">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </div>
        </div>
    </div>
</body>
</html>
