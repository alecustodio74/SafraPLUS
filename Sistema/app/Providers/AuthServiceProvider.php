<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate; // <-- IMPORTANTE
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate para o Administrador
        Gate::define('is-admin', function ($user) {
            return $user->role == 'admin';
        });

        // Gate para o Produtor (Usuário Comum)
        Gate::define('is-produtor', function ($user) {
            return $user->role == 'produtor';
        });
    }
}