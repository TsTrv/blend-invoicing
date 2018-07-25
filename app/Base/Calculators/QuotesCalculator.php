<?php

namespace App\Base\Calculators;

class QuotesCalculator extends Calculator
{
    /**
     * Call the calculation methods.
     */
    public function calculate()
    {
        $this->calculateItems();
    }
}
