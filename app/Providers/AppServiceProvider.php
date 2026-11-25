<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (app()->environment('production') || str_contains(request()->getHost(), 'onrender.com') || str_contains(request()->getHost(), 'trycloudflare.com')) {
            URL::forceScheme('https');
        }
    }
}