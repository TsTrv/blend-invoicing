<?php

namespace App\Modules\Invoices\Repositories;

use App\Base\Repositories\EloquentRepository;
use App\Modules\Invoices\Repositories\Interfaces\InvoiceRepositoryInterface;
use App\Modules\Invoices\Repositories\Interfaces\InvoiceItemRepositoryInterface;
use App\Modules\Invoices\Models\Invoice;
use App\Helpers\Formatter;
use App\Base\Calculators\InvoiceCalculator;

class InvoiceRepository extends EloquentRepository implements InvoiceRepositoryInterface
{

    protected $invoiceItemRepository;

    public function __construct(
        Invoice $model,
        InvoiceItemRepositoryInterface $invoiceItemRepository
    ) {
        $this->model = $model;
        $this->invoiceItemRepository = $invoiceItemRepository;
    }

    public function create($input)
    {
        $input = [
            'user_id' => 1,
            'status_id' => 1,
            'number' => rand(10000, 99999),
            'currency_code' => config('blend.defaultCurrency'),
            'issued_date' => Formatter::unformat($input['issued_date']),
            'due_date' => Formatter::incrementDateByDays(Formatter::unformat($input['issued_date']), config('blend.invoicesDueAfter'))
        ] + $input;

        return parent::create($input);
    }

    public function update($id, $input)
    {
        $invoiceInput = [
            'number' => $input['number'],
            'issued_date' => Formatter::unformat($input['issued_date']),
            'due_date' => Formatter::unformat($input['due_date']),
            'status_id' => $input['status_id'],
            'terms' => $input['terms'],
            'currency_code' => $input['currency_code']
        ];

        $this->invoiceItemRepository->saveItems($id, $input['item']);

        $this->calculateBalances($id);

        return parent::update($id, $invoiceInput);
    }

    /**
     * Delete Items
     * 
     * @param  [type] $id [description]
     * 
     * @return [type]     [description]
     */
    public function deleteItem($id)
    {
        if ($item = $this->invoiceItemRepository->getById($id)) {
            $this->invoiceItemRepository->delete($id);
        }
        $this->calculateBalances($item->invoice_id);
    }

    /**
     * Calculate Balances
     * 
     * @return [type] [description]
     */
    public function calculateBalances($invoiceId)
    {
        $calculator = new InvoiceCalculator;
        $invoice = $this->getById($invoiceId);
        $calculator->setId($invoiceId);

        foreach ($invoice->items as $invoiceItem) {
            $taxRatePercent = ($invoiceItem->tax_rate_id) ? $invoiceItem->tax->percent : 0;
            $calculator->addItem($invoiceItem->id, $invoiceItem->quantity, $invoiceItem->price, $taxRatePercent);
        }

        $calculator->calculate();

        $calculatedItemAmounts = $calculator->getCalculatedItemAmounts();
        $calculatedAmount = $calculator->getCalculatedAmount();

        foreach ($calculatedItemAmounts as $calculatedItemAmount) {
            $itemId = $calculatedItemAmount['item_id'];
            unset($calculatedItemAmount['item_id']);

            $this->invoiceItemRepository->update($itemId, $calculatedItemAmount);
        }

        parent::update($invoiceId, $calculatedAmount);
    }
}
