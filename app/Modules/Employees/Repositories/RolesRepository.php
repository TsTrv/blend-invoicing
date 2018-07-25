<?php

namespace App\Modules\Employees\Repositories;

use App\Base\Repositories\EloquentRepository;
use App\Modules\Employees\Repositories\Interfaces\RolesRepositoryInterface;
use App\Role;

class RolesRepository extends EloquentRepository implements RolesRepositoryInterface
{

    public function __construct(Role $model)
    {
        $this->model = $model;
    }
}
