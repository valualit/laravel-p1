<?php

Route::group(['module' => 'Serm1', 'middleware' => ['api'], 'namespace' => 'App\Modules\Serm1\Controllers'], function() {

    Route::resource('serm1', 'Serm1Controller');

});
