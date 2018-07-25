<?php

namespace App\Base\Calculators;

class InvoiceCalculator extends Calculator
{
    /**
     * Call the calculation methods.
     */
    public function calculate()
    {
        $this->calculateItems();
    }
}
