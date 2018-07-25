<?php

namespace App\Modules\Quotes\Repositories;

use App\Base\Repositories\EloquentRepository;
use App\Modules\Quotes\Repositories\Interfaces\QuoteItemRepositoryInterface;
use App\Modules\Quotes\Models\QuoteItem;
use App\Helpers\Formatter;

class QuoteItemRepository extends EloquentRepository implements QuoteItemRepositoryInterface
{

    public function __construct(QuoteItem $model)
    {
        $this->model = $model;
    }

    public function saveItems($quoteId, $inputs)
    {
        for ($i=0; $i < count($inputs['id']); $i++) {
            $itemInput = [
                'quote_id' => $quoteId,
                'tax_rate_id' => $inputs['tax_rate_id'][$i],
                'name' => $inputs['name'][$i],
                'description' => $inputs['description'][$i],
                'quantity' => $inputs['quantity'][$i],
                'price' => Formatter::unmoney($inputs['price'][$i])
            ];

            if (!$quoteItem = $this->getById($inputs['id'][$i])) {
                $quoteItem = $this->create($itemInput);
            } else {
                $quoteItem = $this->update($quoteItem->id, $itemInput);
            }
        }
    }
}
