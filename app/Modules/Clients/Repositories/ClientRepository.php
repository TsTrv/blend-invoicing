<?php

namespace App\Modules\Clients\Repositories;

use App\Base\Repositories\EloquentRepository;
use App\Modules\Clients\Repositories\Interfaces\ClientRepositoryInterface;
use App\Modules\Clients\Models\Client;
use Response;

class ClientRepository extends EloquentRepository implements ClientRepositoryInterface
{

    public function __construct(Client $model)
    {
        $this->model = $model;
    }

    /**
     * [getSelect2Data description]
     * 
     * @param  [type]  $filter [description]
     * @param  [type]  $offset [description]
     * @param  integer $limit  [description]
     * @return [type]          [description]
     */
    public function getSelect2Data($filter, $offset, $limit = 10)
    {
        $qry = $this->model->select('id', 'name');
        
        if ($filter) {
            $qry->whereRaw('name like ?', [$filter.'%']);
        }
        
        $total = $qry->count();
        $items = $qry->skip($offset)->take($limit)->get();
        return Response::json(['incomplete_results' => false, 'total_count' => $total, 'items' => $items]);
    }
}
