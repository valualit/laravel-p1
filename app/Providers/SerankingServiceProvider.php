<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SerankingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Seranking','App\Services\Seranking');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
