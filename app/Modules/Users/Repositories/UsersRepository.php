<?php

namespace App\Modules\Users\Repositories;

use App\Modules\Users\Repositories\Interfaces\UsersRepositoryInterface;
use App\Base\Repositories\EloquentRepository;
use App\Modules\Users\Models\User;

class UsersRepository extends EloquentRepository implements UsersRepositoryInterface
{
    /**
     * Construct
     * 
     * @param User $model [description]
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }
}
