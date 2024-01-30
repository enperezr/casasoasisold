<?php

namespace App\Providers;

use App\Ad;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('alpha_enumerator', function($attribute, $value, $parameters) {
            return preg_match('/^[A-Z, ]+$/i',$value);
        });
        Validator::extend('numeric_enumerator', function($attribute, $value, $parameters) {
            return preg_match('/^[0-9, ]+$/i',$value);
        });
        view()->share('ads', Ad::getAvailable());
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
