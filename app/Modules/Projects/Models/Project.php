<?php

namespace App\Modules\Projects\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Clients\Models\Client;

class Project extends Model
{
    protected $fillable = [
        'name',
        'client_id',
        'description'
    ];

    /**
     * Client Relation
     * 
     * @return [type] [description]
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
