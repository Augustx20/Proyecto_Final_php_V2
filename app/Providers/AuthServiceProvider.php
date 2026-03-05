<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Turno;
use App\Policies\TurnoPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Los mapeos de políticas para la aplicación.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Turno::class => TurnoPolicy::class,
    ];

    /**
     * Registra cualquier servicio de autenticación / autorización.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
