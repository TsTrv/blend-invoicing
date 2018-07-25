<?php

namespace App\Modules\Clients\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Formatter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{    
    protected $fillable = [
        'name',
        'email',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'phone',
        'web',
        'active'
    ];

    /**
     * Client balance
     * 
     * @return string
     */
    public function getBalanceFormattedAttribute()
    {
        return Formatter::money(0);
    }

    /**
     * Active client muttator
     * 
     * @return string
     */
    public function getActiveFormattedAttribute()
    {
        return Formatter::boolString($this->active);
    }

    /**
     * Formatted Location Attribute
     * 
     * @return [type] [description]
     */
    public function getAddressFormattedAttribute()
    {
        return implode('<br/>', [
            $this->address,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country
        ]);
    }
}
