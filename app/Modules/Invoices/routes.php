<?php

Route::group(['middleware' => ['web']], function () {

	Route::get('invoices/datatable', [
        'uses' => '\App\Modules\Invoices\Controllers\InvoicesController@datatable',
        'as' => 'invoices.datatable'
    ]);

    Route::get('invoice/item/{id}/destroy', [
        'uses' => '\App\Modules\Invoices\Controllers\InvoicesController@deleteItem',
        'as' => 'invoices.item.delete'
    ]);

    Route::get('invoice/{id}/destroy', [
        'uses' => '\App\Modules\Invoices\Controllers\InvoicesController@destroy',
        'as' => 'invoices.delete'
    ]);

    Route::get('invoice/{id}/pdf/{mode}', [
        'uses' => '\App\Modules\Invoices\Controllers\InvoicesController@pdf',
        'as' => 'invoices.pdf.view'
    ]);

    Route::resource('invoices', '\App\Modules\Invoices\Controllers\InvoicesController',
        [
            'names' => [
                'index' => 'invoices.index',
                'create' => 'invoices.create',
                'show' => 'invoices.show',
                'edit' => 'invoices.edit',
                'store' => 'invoices.store',
                'update' => 'invoices.update'
            ]
        ]
    );

});
