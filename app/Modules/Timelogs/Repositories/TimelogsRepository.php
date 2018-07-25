<?php

namespace App\Modules\Timelogs\Repositories;

use App\Modules\Timelogs\Repositories\Interfaces\TimelogsRepositoryInterface;
use App\Base\Repositories\EloquentRepository;
use App\Modules\Timelogs\Models\Timelog;
use App\Helpers\Formatter;

class TimelogsRepository extends EloquentRepository implements TimelogsRepositoryInterface
{
    /**
     * Construct
     * 
     * @param Timelog $model [description]
     */
    public function __construct(Timelog $model)
    {
        $this->model = $model;
    }

    /**
     * Create
     * 
     * @param  [type] $input [description]
     * @return [type]        [description]
     */
    public function create($input)
    {
        $input['date'] = Formatter::unformat($input['date']);
        parent::create($input);
    }

    /**
     * Update
     * 
     * @param  [type] $id    [description]
     * @param  [type] $input [description]
     * 
     * @return [type]        [description]
     */
    public function update($id, $input)
    {
        $input['date'] = Formatter::unformat($input['date']);
        parent::update($id, $input);
    }

    /**
     * [thisWeek description]
     * @return [type] [description]
     */
    public function thisWeek()
    {
        $default = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday',
        ];

        $respose = array_fill_keys($default, 0);

        $dataSet = $this->model->selectRaw('DAYNAME(date) as day, sum(total) as totalDaily')
            ->whereRaw('WEEKOFYEAR(date)=WEEKOFYEAR(NOW())')
            ->groupBy('date')
            ->get()
            ->toArray();

        foreach ($dataSet as $key => $value) {
            if (array_key_exists($value['day'], $respose)) {
                $respose[$value['day']] = $value['totalDaily'];
            }
        }
        
        return response()->json($respose);
    }
}
