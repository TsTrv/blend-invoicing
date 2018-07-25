<?php

namespace App\Modules\Invoices\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Formatter;
use App\Modules\Clients\Models\Client;
use App\Modules\Taxes\Models\Tax;
use App\Modules\Currencies\Models\Currency;
use App\Modules\Invoices\Models\Invoice;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
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

    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_rate_id');
    }

    /**
     * [invoice description]
     * 
     * @return [type] [description]
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Currency relation.
     * 
     * @return [type] [description]
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_code', 'code');
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
        return $this->price;
    }

    /**
     * [getFormattedPriceAttribute description]
     * 
     * @return [type] [description]
     */
    public function getFormattedPriceAttribute()
    {
        return Formatter::money($this->price, $this->invoice->currency);
    }

    /**
     * [getFormattedSubtotalAttribute description]
     * @return [type] [description]
     */
    public function getFormattedSubtotalAttribute()
    {
        return Formatter::money($this->subtotal, $this->invoice->currency);
    }

    /**
     * [getFormattedSubtotalAttribute description]
     * @return [type] [description]
     */
    public function getFormattedTotalAttribute()
    {
        return Formatter::money($this->total, $this->invoice->currency);
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
