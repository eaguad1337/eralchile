<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'EAguad\Model\Order' => 'App\Policies\OrderPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('approve', 'App\Policies\OrderPolicy@approve');
        Gate::define('reject', 'App\Policies\OrderPolicy@reject');
        Gate::define('sign', 'App\Policies\OrderPolicy@sign');
    }
}
