<?php

namespace App\Modules\Invoices\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Formatter;
use App\Modules\Clients\Models\Client;
use App\Modules\Currencies\Models\Currency;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    
    protected $statuses = [
        '0' => 'all',
        '1' => 'draft',
        '2' => 'sent',
        '3' => 'paid',
        '4' => 'canceled'
    ];

    protected $fillable = [
        'user_id',
        'client_id',
        'status_id',
        'due_date',
        'issued_date',
        'number',
        'terms',
        'subtotal',
        'tax',
        'total',
        'currency_code'
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

    /**
     * Items Relation 
     * 
     * @return [type] [description]
     */
    public function items()
    {
        return $this->hasMany(InvoiceItem::class)->orderBy('display_order');
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
     * Invoice statuses
     * 
     * @return [type] [description]
     */
    public function statuses()
    {
        $statusList = $this->statuses;
        unset($statusList[0]);
        return $statusList;
    }

    /**
     * [getStatusLavelAttribute description]
     * 
     * @return [type] [description]
     */
    public function getStatusLabelAttribute()
    {
        return $this->statuses[$this->status_id];
    }

    /**
     * Issued Date Formatted
     * 
     * @return string
     */
    public function getIssuedDateFormattedAttribute()
    {
        return Formatter::format($this->issued_date);
    }

    /**
     * Due Date Formatted
     * 
     * @return string
     */
    public function getDueDateFormattedAttribute()
    {
        return Formatter::format($this->due_date);
    }

    /**
     * Item Subtotal Formatted
     * 
     * @return [type] [description]
     */
    public function getSubtotalFormattedAttribute()
    {
        return Formatter::money($this->subtotal, $this->currency);
    }

    /**
     * Item Tax Formatted
     * 
     * @return [type] [description]
     */
    public function getTaxFormattedAttribute()
    {
        return Formatter::money($this->tax, $this->currency);
    }

    /**
     * Total Formatted
     * @return [type] [description]
     */
    public function getTotalFormattedAttribute()
    {
        return Formatter::money($this->total, $this->currency);
    }

    /**
     * [getFormattedDescriptionAttribute description]
     * 
     * @return [type] [description]
     */
    public function getFormattedTermsAttribute()
    {
        return nl2br($this->terms);
    }
}
