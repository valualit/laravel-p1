<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EntitiesFieldsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(){
        $this->app->bind('EntitiesFields','App\Services\EntitiesFields');
    }
}
