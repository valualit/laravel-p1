<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class isInstallServiceProvider extends ServiceProvider
{
	static private $Install = false;
    /**
     * Register services.
     *
     * @return void
     */
    public function register(){
        // 
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(){
		if (!Schema::hasTable('users')) {
			Artisan::call('key:generate');
			Artisan::call('migrate');
			Artisan::call('db:seed');
		} else {
			self::$Install = true;
		}
    }
	
    public function isInstall() : bool {
        return self::$Install;
    }
}
