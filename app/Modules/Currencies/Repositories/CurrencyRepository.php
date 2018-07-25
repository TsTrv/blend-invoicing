<?php

namespace App\Modules\Currencies\Repositories;

use App\Base\Repositories\EloquentRepository;
use App\Modules\Currencies\Repositories\Interfaces\CurrencyRepositoryInterface;
use App\Modules\Currencies\Models\Currency;

class CurrencyRepository extends EloquentRepository implements CurrencyRepositoryInterface
{

    /**
     * [__construct description]
     * @param Currency $model [description]
     */
    public function __construct(Currency $model)
    {
        $this->model = $model;
    }

    /**
     * [getByCode description]
     * 
     * @param  [type] $code [description]
     * 
     * @return [type]       [description]
     */
    public function getByCode($code)
    {
        return $this->getByMany(['code'=>$code])->first();
    }
}
