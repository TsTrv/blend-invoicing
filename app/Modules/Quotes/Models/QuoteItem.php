<?php

namespace App\Modules\Quotes\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Formatter;
use App\Modules\Clients\Models\Client;
use App\Modules\Taxes\Models\Tax;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuoteItem extends Model
{
    
    protected $fillable = [
        'quote_id',
        'tax_rate_id',
        'name',
        'description',
        'quantity',
        'price',
        'display_order',
        'subtotal',
        'tax_total',
        'total'
    ];

    /**
     * [tax description]
     * @return [type] [description]
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_rate_id');
    }

    /**
     * [quote description]
     * @return [type] [description]
     */
    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    /**
     * [getFormattedQuantityAttribute description]
     * 
     * @return [type] [description]
     */
    public function getFormattedQuantityAttribute()
    {
        return $this->quantity;
    }

    /**
     * [getFormattedNumericPriceAttribute description]
     * 
     * @return [type] [description]
     */
    public function getFormattedNumericPriceAttribute()
    {
        return Formatter::money($this->price, $this->quote->currency);
    }

    /**
     * [getFormattedPriceAttribute description]
     * 
     * @return [type] [description]
     */
    public function getFormattedPriceAttribute()
    {
        return Formatter::money($this->price, $this->quote->currency);
    }

    /**
     * [getFormattedSubtotalAttribute description]
     * @return [type] [description]
     */
    public function getFormattedSubtotalAttribute()
    {
        return Formatter::money($this->subtotal, $this->quote->currency);
    }

    /**
     * [getFormattedDescriptionAttribute description]
     * 
     * @return [type] [description]
     */
    public function getFormattedDescriptionAttribute()
    {
        return nl2br($this->description);
    }
}
