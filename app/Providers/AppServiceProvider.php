<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Route;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('includes.menu', function ($view) {
            $view->with('current', preg_replace('/\..*/', '', Route::currentRouteName()));
        });

        view()->composer('*', function ($view) {
            $view->with('user', Auth::user() ? : false);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
