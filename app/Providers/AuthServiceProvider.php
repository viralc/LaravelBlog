<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateGuard $gate)
    {
        $this->registerPolicies($gate);
        $gate->define('isAdmin', function($user){
            return $user->type == 'admin';
        });
        $gate->define('isUser', function($user){
            return $user->type == 'user';
        });
    }
}
