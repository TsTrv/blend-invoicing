<?php

namespace App\Modules\Projects\Repositories;

use App\Base\Repositories\EloquentRepository;
use App\Modules\Projects\Repositories\Interfaces\ProjectsRepositoryInterface;
use App\Modules\Projects\Models\Project;
use App\Helpers\Formatter;

class ProjectsRepository extends EloquentRepository implements ProjectsRepositoryInterface
{

    public function __construct(Project $model)
    {
        $this->model = $model;
    }
}
