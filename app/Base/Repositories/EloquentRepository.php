<?php

namespace App\Base\Repositories;

use DB;

/**
 * Class EloquentRepository.
 */
class EloquentRepository
{

    /**
     * The model the repository should interact with.
     *
     * @var Illuminate\Database\Eloquent\Model  $model
     */
    protected $model;

    /**
     * An amount of paginated results for fetch queries by this repository.
     *
     * @var int
     */
    protected $paginateCount;

    /**
     * Set if create / update methods should add created_by / updated_by fields.
     *
     * @var bool
     */
    protected $addCreatorAndUpdater = true;

    /**
     * Called when the repository should construct itself.
     *
     * @param Eloquent $model
     */
    public function __construct(Eloquent $model)
    {
        $this->model = $model;
    }

    /**
     * Check if an item exists on a model.
     *
     * @param  string  $key
     * @param  string  $value
     * @param  string  $operator
     * @return bool
     */
    public function has($key, $value, $operator = '=')
    {
        $result = $this->model->where($key, $operator, $value)->first();

        return isset($result);
    }

    /**
     * Retrieve an item by its identifier.
     *
     * @param  int  $id
     * @return array
     */
    public function getById($id, $withTrashed = false)
    {
        $model = ($withTrashed ? $this->model->withTrashed() : $this->model);
        return $model->find($id);
    }

    /**
     * Retrieves a set of data by multiple identifiers.
     *
     * @param  array  $ids
     * @return Model
     */
    public function getByIds(array $ids)
    {
        // Remove any blank ids.
        $ids = array_filter($ids);

        return $this->fetch($this->model->whereRaw(DB::raw('id IN (' . implode(',', $ids) . ')')));
    }

    /**
     * Retrieves an item by many attributes.
     *
     * @param  array  $attributes
     * @return Model
     */
    public function getByMany(array $attributes)
    {
        $statement = $this->model;

        // Iterate through each of the provided attributes
        // and chain on a where statement for each field
        // and value. (TODO: Add operator support)
        foreach ($attributes as $field => $value) {
            $statement = $statement->where($field, '=', $value);
        }

        return $statement;
    }

    /**
     * Retrieve all items from the model.
     */
    public function getAll()
    {
        return $this->fetch($this->model);
    }

    /**
     * Retrieves all items from the model in a specified order.
     *
     * @param  string  $field
     * @param  string  $order
     * @return Model
     */
    public function getAllOrderedWithDate($field, $order)
    {
        return $this->fetch($this->model->where('date', '>', date('Y-m-d H:i:s'))->orderBy($field, $order));
    }

    /**
     * Retrieves all items from the model in a specified order.
     *
     * @param  string  $field
     * @param  string  $order
     * @return Model
     */
    public function getAllOrdered($field, $order)
    {
        return $this->fetch($this->model->orderBy($field, $order));
    }

    /**
     * Fetches items from the repository.
     *
     * @param  Illuminate\Database\Query\Builder  $query
     * @return Illuminate\Support\Collection
     */
    protected function fetch($query)
    {
        // If a paginate counter has been applied to this class,
        // we will fetch the results paginated. Otherwise,
        // we will retrieve the results with a 'get()'.
        if (isset($this->paginationCount)) {
            return $query->paginate($this->paginationCount);
        }

        return $query->get();
    }

    /**
     * Creates a new entry in the model.
     *
     * @param  array  $data
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($data)
    {
        // // TODO: do this with sentry
        // if ($this->addCreatorAndUpdater) {
        //     $data['created_by'] = array_key_exists('created_by', $data) ? $data['created_by'] : (Sentinel::getUser() ? Sentinel::getUser()->id : 1);
        //     $data['updated_by'] = array_key_exists('updated_by', $data) ? $data['updated_by'] : (Sentinel::getUser() ? Sentinel::getUser()->id : 1);
        // }

        // collect relation data into separate array
        $relations = [];
        foreach ($data as $key => $value) {
            if (is_array($value) && method_exists($this->model, $key)) {
                $relations[$key] = $value;
                unset($data[$key]);
            }
        }

        $instance = $this->model->create($data);

        // reload model - this hac need to force refreshing primary key
        // when primary key is not increment and it will be 0 without reloading model
        // TODO: make it better
        if (array_key_exists($instance->getKeyName(), $data)) {
            $instance = $this->getById($data[$instance->getKeyName()]);
        }

        // add relation data
        foreach ($relations as $relationName => $relationData) {
            $instance->$relationName()->sync($relationData);
        }

        return $instance;
    }

    /**
     * Updates an existing model.
     *
     * @param  int  $id
     * @param  array  $data
     * @return Model
     */
    public function update($id, $data)
    {
        // load instance
        $instance = $this->model->where($this->model->getKeyName(), '=', $id)->first();

        // collect relation data into separate array
        $relations = [];
        foreach ($data as $key => $value) {
            if (is_array($value) && method_exists($this->model, $key)) {
                $relations[$key] = $value;
                unset($data[$key]);
            }
        }

        // update model
        $instance->update($data);

        // update relation data
        foreach ($relations as $relationName => $relationData) {
            $instance->$relationName()->sync($relationData);
        }

        return $instance;
    }

    /**
     * Removes an entry from the model.
     *
     * @param $id
     *
     * @return bool|null
     */
    public function delete($id)
    {
        return $this->model->where('id', '=', $id)->delete();
    }

    /**
     * Restores a soft deleted entry.
     *
     * @param  int  $id
     * @return <result>
     */
    public function restore($id)
    {
        return $this->model->where('id', '=', $id)->restore();
    }

    /**
     * Paginate.
     *
     * @param $items
     * @param bool $limit
     *
     * @return \Illuminate\Pagination\Paginator
     */
    public function paginate($items, $limit = false)
    {
        if (is_array($items)) {
            $items = Illuminate\Database\Eloquent\Collection::make($items);
        }

        if (!$limit) {
            $limit = $this->paginationCount;
        }

        $currentPage = Input::get('page') ? Input::get('page') - 1 : 0 ;
        $pagedData = $items->slice($currentPage * $limit, $limit)->all();

        return Paginator::make($pagedData, count($items), $limit);
    }

    /**
     * [getForBladeSelect description]
     * @return [type] [description]
     */
    public function getForBladeSelect($value, $key)
    {
        return $this->model->pluck($value, $key)->all();
    }


    /**
     * Datatables Query. 
     * 
     * @param  [type] $filter [description]
     * 
     * @return [type]         [description]
     */
    public function getQry($filter = [], $columns = [])
    {
        $response = DB::table($this->model->getTable())->whereNull('deleted_at');
        
        foreach ($filter as $key => $value) {
            $response->where($value['key'], $value['operator'], $value['value']);
        }
        if ($columns) {
            $response->select($columns);
        }
        return $response;
    }

    /**
     * Datatables Collection.
     * 
     * @param  array  $filter  [description]
     * @param  array  $columns [description]
     * @return [type]          [description]
     */
    public function datatableCollection($filter = [], $columns = [])
    {
        $response = $this->model->where([]);//Null('deleted_at');

        foreach ($filter as $key => $value) {
            $response->where($value['key'], $value['operator'], $value['value']);
        }

        if ($columns) {
            return $response->select($columns);
        }

        $response = $response->get();

        return $response;
    }
}
