<?php

Route::match('get',"/".config('app.admin_url','admin')."/serm",['as' => 'admin.module.serm.index','uses' => 'App\Modules\Serm\Controllers\SermAdminController@index']);

Route::match('get',"/serm",['as' => 'module.serm.index','uses' => 'App\Modules\Serm\Controllers\SermController@index']);
		

