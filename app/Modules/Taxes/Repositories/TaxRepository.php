<?php

namespace App\Modules\Taxes\Repositories;

use App\Base\Repositories\EloquentRepository;
use App\Modules\Taxes\Repositories\Interfaces\TaxRepositoryInterface;
use App\Modules\Taxes\Models\Tax;
use App\Helpers\Formatter;

class TaxRepository extends EloquentRepository implements TaxRepositoryInterface
{

    public function __construct(Tax $model)
    {
        $this->model = $model;
    }
}
