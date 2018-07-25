<?php

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::get('users/datatable', [
        'uses' => '\App\Modules\Users\Controllers\UsersController@datatable',
        'as' => 'users.datatable'
    ]);

    Route::resource('users', '\App\Modules\Users\Controllers\UsersController',
        [
            'names' => [
                'index' => 'users.index',
                'create' => 'users.create',
                'show' => 'users.show',
                'edit' => 'users.edit',
                'store' => 'users.store',
                'update' => 'users.update',
                'destroy' => 'users.delete'
            ]
        ]
    );

});
