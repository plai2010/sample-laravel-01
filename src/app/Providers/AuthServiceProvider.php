<?php

namespace App\Providers;

use Auth;

use Illuminate\Auth\RequestGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Check for admin user by consulting the 'admin' column of
        // the 'users' table.
        Auth::extend('users_admin', function($app) {
            return new RequestGuard(function($req) {
                $user = Auth::user();
            //  \Log::debug('auth:admins user='.($user ? $user->name : '???'));
                return $user->admin ? $user : null;
            }, $app['request'], null);
        });
    }
}

// vim: set ts=4 expandtab syntax=php:
