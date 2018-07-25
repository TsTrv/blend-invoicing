<?php

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::get('currencies', [
        'uses' => '\App\Modules\Currencies\Controllers\CurrenciesController@index',
        'as' => 'currencies.index'
    ]);

    Route::get('currencies/datatable', [
        'uses' => '\App\Modules\Currencies\Controllers\CurrenciesController@datatable',
        'as' => 'currencies.datatable'
    ]);

});
