<?php

namespace App\Providers;

use App\Models\Miembro;
use App\Policies\MiembroPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Miembro::class => MiembroPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
