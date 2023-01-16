<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('admin', function ($user) {
            return $user->is_admin;
        });

        Gate::define('cs', function ($user) {
            return !$user->is_admin;
        });

        if(config('app.env') === 'production'){
            URL::forceScheme('https');
        }

    }
}
