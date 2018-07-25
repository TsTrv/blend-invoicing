<?php

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::get('clients/datatable', [
        'uses' => '\App\Modules\Clients\Controllers\ClientsController@datatable',
        'as' => 'clients.datatable'
    ]);

    Route::get('clients/select-json', [
        'uses' => '\App\Modules\Clients\Controllers\ClientsController@selectJson',
        'as' => 'clients.selectjson'
    ]);

    Route::get('clients/{id}/destroy', [
        'uses' => '\App\Modules\Clients\Controllers\ClientsController@destroy',
        'as' => 'clients.delete'
    ]);

    Route::resource('clients', '\App\Modules\Clients\Controllers\ClientsController',
        [
            'names' => [
                'index' => 'clients.index',
                'create' => 'clients.create',
                'show' => 'clients.show',
                'edit' => 'clients.edit',
                'store' => 'clients.store',
                'update' => 'clients.update',
                'destroy' => 'clients.destroy'
            ]
        ]
    );

});
