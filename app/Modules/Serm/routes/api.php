<?php

Route::group(['module' => 'Serm', 'middleware' => ['api'], 'namespace' => 'App\Modules\Serm\Controllers'], function() {

    Route::resource('serm', 'SermController');

});
