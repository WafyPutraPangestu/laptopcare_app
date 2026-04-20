<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('Teknisi', function ($user) {
            return $user->role === 'Teknisi';
        });
        Gate::define('Kepala_IT', function ($user) {
            return $user->role === 'Kepala_IT';
        });
        Gate::define('User', function ($user) {
            return $user->role === 'User';
        });
    }
}
