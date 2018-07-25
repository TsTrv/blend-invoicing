<?php

Route::group(['middleware' => ['web']], function () {

    Route::get('quotes/datatable', [
        'uses' => '\App\Modules\Quotes\Controllers\QuotesController@datatable',
        'as' => 'quotes.datatable'
    ]);

    Route::get('quotes/item/{id}/destroy', [
        'uses' => '\App\Modules\Quotes\Controllers\QuotesController@deleteItem',
        'as' => 'quotes.item.delete'
    ]);

    Route::get('quotes/{id}/destroy', [
        'uses' => '\App\Modules\Quotes\Controllers\QuotesController@destroy',
        'as' => 'quotes.delete'
    ]);

    Route::get('quotes/{id}/pdf/{mode}', [
        'uses' => '\App\Modules\Quotes\Controllers\QuotesController@pdf',
        'as' => 'quotes.pdf.view'
    ]);

    Route::resource('quotes', '\App\Modules\Quotes\Controllers\QuotesController',
        [
            'names' => [
                'index' => 'quotes.index',
                'create' => 'quotes.create',
                'show' => 'quotes.show',
                'edit' => 'quotes.edit',
                'store' => 'quotes.store',
                'update' => 'quotes.update'
            ]
        ]
    );

});
