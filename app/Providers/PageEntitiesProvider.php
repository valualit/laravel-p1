<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PageEntitiesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void 
     */
    public function register(){
        $this->app->bind('PageEntities','App\Services\PageEntities');
    }
}
