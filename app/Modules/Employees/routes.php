<?php

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::get('employees/datatable', [
        'uses' => '\App\Modules\Employees\Controllers\EmployeesController@datatable',
        'as' => 'employees.datatable'
    ]);

    Route::get('employees/{id}/delete', [
        'uses' => '\App\Modules\Employees\Controllers\EmployeesController@destroy',
        'as' => 'employees.delete'
    ]);

    Route::resource('employees', '\App\Modules\Employees\Controllers\EmployeesController',
        [
            'names' => [
                'index' => 'employees.index',
                'create' => 'employees.create',
                'show' => 'employees.show',
                'edit' => 'employees.edit',
                'store' => 'employees.store',
                'update' => 'employees.update'
            ]
        ]
    );

});
