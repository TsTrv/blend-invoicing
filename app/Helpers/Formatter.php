<?php 

namespace App\Helpers;

use DateTime;
use DateInterval;

class Formatter
{
    /**
     * Format money.
     * 
     * @return string
     */
    public static function money($amount, $currency = null, $decimalPlaces = null)
    {
        $currency = ($currency) ?: config('blend.currency');

        $decimalPlaces = ($decimalPlaces) ?: config('blend.amountDecimals');

        $amount = number_format($amount, $decimalPlaces, $currency->decimal, $currency->thousands);

        if ($currency->placement == 'before') {
            return $currency->symbol.$amount;
        }

        return $amount.$currency->symbol;
    }

    /**
     * Unformats a formatted number.
     *
     * @param  float $number
     * @param  object $currency
     * 
     * @return float
     */
    public static function unmoney($number, $currency = null)
    {
        return preg_replace("/([^0-9\\.])/i", "", $number);
    }

    /**
     * Boolean to Yes/No.
     * 
     * @param  [type] $bool [description]
     * 
     * @return [type]       [description]
     */
    public static function boolString($bool)
    {
        return $bool ? 'Yes' : 'No';
    }

    /**
     * Format Date.
     * 
     * @param  [type]  $date        [description]
     * @param  boolean $includeTime [description]
     * 
     * @return [type]               [description]
     */
    public static function format($date = null, $includeTime = false)
    {
        $date = new DateTime($date);

        if (!$includeTime) {
            return $date->format(config('blend.dateFormat'));
        }

        return $date->format(config('blend.dateFormat') . ' h:i:s A');
    }

    /**
     * Unformat Date.
     * 
     * @param  [type] $date [description]
     * @return [type]       [description]
     */
    public static function unformat($date = null)
    {
        if ($date) {
            $pureDate = DateTime::createFromFormat(config('blend.dateFormat'), $date);

            return $pureDate->format('Y-m-d');
        }

        return null;
    }

    
    /**
     * incrementDateByDays
     * 
     * @param  [type] $date    [description]
     * @param  [type] $numDays [description]
     * 
     * @return [type]          [description]
     */
    public static function incrementDateByDays($date, $numDays)
    {
        $date = DateTime::createFromFormat('Y-m-d', $date);

        $date->add(new DateInterval('P'.$numDays.'D'));

        return $date->format('Y-m-d');
    }
}
