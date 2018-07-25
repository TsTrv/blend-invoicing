<?php

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::get('dashboard', [
        'uses' => '\App\Modules\Dashboard\Controllers\DashboardController@index',
        'as' => 'dashboard.index'
    ]);

});
