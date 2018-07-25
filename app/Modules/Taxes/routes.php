<?php

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::get('taxes', [
        'uses' => '\App\Modules\Taxes\Controllers\TaxesController@index',
        'as' => 'taxes.index'
    ]);

    Route::get('taxes/datatable', [
        'uses' => '\App\Modules\Taxes\Controllers\TaxesController@datatable',
        'as' => 'taxes.datatable'
    ]);

});
