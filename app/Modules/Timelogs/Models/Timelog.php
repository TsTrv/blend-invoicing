<?php

namespace App\Modules\Timelogs\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Users\Models\User;
use App\Modules\Projects\Models\Project;
use App\Helpers\Formatter;

class Timelog extends Model
{
    protected $fillable = [
        'user_id',
        'project_id',
        'total',
        'date',
        'description'
    ];

    /**
     * Employee Relation
     * 
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Project Relation
     * 
     * @return mixed
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Date formatted
     * 
     * @return string
     */
    public function getDateFormattedAttribute()
    {
        return Formatter::format($this->date);
    }
}
