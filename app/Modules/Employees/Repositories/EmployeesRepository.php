<?php

namespace App\Modules\Employees\Repositories;

use App\Base\Repositories\EloquentRepository;
use App\Modules\Employees\Repositories\Interfaces\EmployeesRepositoryInterface;
use App\Modules\Users\Models\User;

class EmployeesRepository extends EloquentRepository implements EmployeesRepositoryInterface
{

    /**
     * [__construct description]
     * @param User $model [description]
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * [create description]
     * @param  [type] $input [description]
     * @return [type]        [description]
     */
    public function create($input)
    {
        $input['password'] = isset($input['password']) ? bcrypt($input['password']) : '';
        $user = parent::create($input);

        if (!$user->hasRole($input['roles'])) {
            $user->roles()->detach();
            $user->assignRole($input['roles']);
        }

        return $user;
    }

    /**
     * [update description]
     * 
     * @param  [type] $id    [description]
     * @param  [type] $input [description]
     * 
     * @return [type]        [description]
     */
    public function update($id, $input)
    {
        if (isset($input['password']) && $input['password']) {
            $input['password'] = bcrypt($input['password']);
        } else {
            unset($input['password']);
        }

        $user = $this->getById($id);

        if (!$user->hasRole($input['roles'])) {
            $user->roles()->detach();
            $user->assignRole($input['roles']);
        }

        return parent::update($id, $input);
    }
}
