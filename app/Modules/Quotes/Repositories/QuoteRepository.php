<?php

namespace App\Modules\Quotes\Repositories;

use App\Base\Repositories\EloquentRepository;
use App\Modules\Quotes\Repositories\Interfaces\QuoteRepositoryInterface;
use App\Modules\Quotes\Repositories\Interfaces\QuoteItemRepositoryInterface;
use App\Modules\Quotes\Models\Quote;
use App\Helpers\Formatter;
use App\Base\Calculators\QuotesCalculator;

class QuoteRepository extends EloquentRepository implements QuoteRepositoryInterface
{

    protected $quoteItemRepository;

    public function __construct(
        Quote $model,
        QuoteItemRepositoryInterface $quoteItemRepository
    ) {
        $this->model = $model;
        $this->quoteItemRepository = $quoteItemRepository;
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
        $quoteInput = [
            'number' => $input['number'],
            'issued_date' => Formatter::unformat($input['issued_date']),
            'due_date' => Formatter::unformat($input['due_date']),
            'status_id' => $input['status_id'],
            'terms' => $input['terms'],
            'currency_code' => $input['currency_code']
        ];

        $this->quoteItemRepository->saveItems($id, $input['item']);

        $this->calculateBalances($id);

        return parent::update($id, $quoteInput);
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
        if ($item = $this->quoteItemRepository->getById($id)) {
            $this->quoteItemRepository->delete($id);
        }
        $this->calculateBalances($item->quote_id);
    }

    /**
     * Calculate Balances
     * 
     * @return [type] [description]
     */
    public function calculateBalances($quoteId)
    {
        $calculator = new QuotesCalculator;
        $quote = $this->getById($quoteId);
        $calculator->setId($quoteId);

        foreach ($quote->items as $quoteItem) {
            $taxRatePercent = ($quoteItem->tax_rate_id) ? $quoteItem->tax->percent : 0;
            $calculator->addItem($quoteItem->id, $quoteItem->quantity, $quoteItem->price, $taxRatePercent);
        }

        $calculator->calculate();

        $calculatedItemAmounts = $calculator->getCalculatedItemAmounts();
        $calculatedAmount = $calculator->getCalculatedAmount();

        foreach ($calculatedItemAmounts as $calculatedItemAmount) {
            $itemId = $calculatedItemAmount['item_id'];
            unset($calculatedItemAmount['item_id']);

            $this->quoteItemRepository->update($itemId, $calculatedItemAmount);
        }

        parent::update($quoteId, $calculatedAmount);
    }
}
