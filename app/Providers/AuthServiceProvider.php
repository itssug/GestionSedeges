<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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
    public function boot()
{
    $this->registerPolicies();

    Gate::before(function ($user, $ability) {
        if ($user->rol->nombre_rol === 'Super Administrador') {
            return true;
        }
    });

    // Gate para Administrador
    Gate::define('is-admin', function ($user) {
        return $user->rol->nombre_rol === 'Administrador';
    });

    // Gate para Adoptantes
    Gate::define('is-adoptante', function ($user) {
        return $user->rol->nombre_rol === 'Adoptantes';
    });

    // Gate para Personal SEDEGES
    Gate::define('is-personal-sedeges', function ($user) {
        return $user->rol->nombre_rol === 'Personal SEDEGES';
    });


    // Gate para Responsables Legales
    Gate::define('is-responsable-legal', function ($user) {
        return $user->rol->nombre_rol === 'Responsables Legales';
    });

    Gate::define('is-super-admin', function ($user) {
        return $user->rol->nombre_rol === 'Super Administrador';
    });
}

}
