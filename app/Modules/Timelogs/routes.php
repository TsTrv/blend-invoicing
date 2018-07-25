<?php

Route::group(['middleware' => ['web', 'auth']], function () {

	Route::get('timelogs/datatable', [
        'uses' => '\App\Modules\Timelogs\Controllers\TimelogsController@datatable',
        'as' => 'timelogs.datatable'
    ]);

    Route::resource('timelogs', '\App\Modules\Timelogs\Controllers\TimelogsController',
        [
            'names' => [
                'index' => 'timelogs.index',
                'create' => 'timelogs.create',
                'show' => 'timelogs.show',
                'edit' => 'timelogs.edit',
                'store' => 'timelogs.store',
                'update' => 'timelogs.update',
                'delete' => 'timelogs.delete'
            ]
        ]
    );

});
