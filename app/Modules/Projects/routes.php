<?php

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::get('projects', [
        'uses' => '\App\Modules\Projects\Controllers\ProjectsController@index',
        'as' => 'projects.index'
    ]);

    Route::get('projects/datatable', [
        'uses' => '\App\Modules\Projects\Controllers\ProjectsController@datatable',
        'as' => 'projects.datatable'
    ]);

    Route::get('projects/{id}/delete', [
        'uses' => '\App\Modules\Projects\Controllers\ProjectsController@destroy',
        'as' => 'projects.delete'
    ]);

    Route::resource('projects', '\App\Modules\Projects\Controllers\ProjectsController',
        [
            'names' => [
                'index' => 'projects.index',
                'create' => 'projects.create',
                'show' => 'projects.show',
                'edit' => 'projects.edit',
                'store' => 'projects.store',
                'update' => 'projects.update',
                'destroy' => 'projects.destroy'
            ]
        ]
    );

});
