<?php

namespace App\Base\Calculators;

abstract class Calculator
{
    /**
     * The id of the quote or invoice.
     *
     * @var int
     */
    protected $id;

    /**
     * An array to store items.
     *
     * @var array
     */
    protected $items = [];

    /**
     * An array to store calculated item amounts.
     *
     * @var array
     */
    protected $calculatedItemAmounts = [];

    /**
     * An array to store overall calculated amounts.
     *
     * @var array
     */
    protected $calculatedAmount = [];

    /**
     * Initialize the calculated amount array.
     */
    public function __construct()
    {
        $this->calculatedAmount = [
            'subtotal' => 0,
            'tax'      => 0,
            'total'    => 0
        ];
    }

    /**
     * Sets the id.
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Adds a item for calculation.
     *
     * @param int $itemId
     * @param float $quantity
     * @param float $price
     * @param float $taxRatePercent
     */
    public function addItem($itemId, $quantity, $price, $taxRatePercent = 0)
    {
        $this->items[] = [
            'itemId'             => $itemId,
            'quantity'           => $quantity,
            'price'              => $price,
            'taxRatePercent'     => $taxRatePercent
        ];
    }

    /**
     * Call the calculation methods.
     */
    public function calculate()
    {
        $this->calculateItems();
    }

    /**
     * Returns calculated item amounts.
     *
     * @return array
     */
    public function getCalculatedItemAmounts()
    {
        return $this->calculatedItemAmounts;
    }

    /**
     * Returns overall calculated amount.
     *
     * @return array
     */
    public function getCalculatedAmount()
    {
        return $this->calculatedAmount;
    }

    /**
     * Calculates the items.
     */
    protected function calculateItems()
    {
        foreach ($this->items as $item) {
            $subtotal = round($item['quantity'] * $item['price'], config('blend.amountDecimals'));

            $taxTotal = 0;    
            if ($item['taxRatePercent']) {
                $taxTotal = round($subtotal * ($item['taxRatePercent'] / 100), config('blend.roundTaxDecimals'));
            }

            $total = $subtotal + $taxTotal;

            $this->calculatedItemAmounts[] = [
                'item_id' => $item['itemId'],
                'subtotal' => $subtotal,
                'tax' => $taxTotal,
                'total' => $total
            ];

            $this->calculatedAmount['subtotal'] += $subtotal;
            $this->calculatedAmount['tax'] += $taxTotal;
            $this->calculatedAmount['total'] += ($total);
        }
    }
}
