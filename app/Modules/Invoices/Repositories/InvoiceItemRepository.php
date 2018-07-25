<?php

namespace App\Modules\Invoices\Repositories;

use App\Base\Repositories\EloquentRepository;
use App\Modules\Invoices\Repositories\Interfaces\InvoiceItemRepositoryInterface;
use App\Modules\Invoices\Models\InvoiceItem;
use App\Helpers\Formatter;

class InvoiceItemRepository extends EloquentRepository implements InvoiceItemRepositoryInterface
{

    public function __construct(InvoiceItem $model)
    {
        $this->model = $model;
    }

    public function saveItems($invoiceId, $inputs)
    {
        for ($i=0; $i < count($inputs['id']); $i++) {
            $itemInput = [
                'invoice_id' => $invoiceId,
                'tax_rate_id' => $inputs['tax_rate_id'][$i],
                'name' => $inputs['name'][$i],
                'description' => $inputs['description'][$i],
                'quantity' => $inputs['quantity'][$i],
                'price' => Formatter::unmoney($inputs['price'][$i])
            ];

            if (!$invoiceItem = $this->getById($inputs['id'][$i])) {
                $invoiceItem = $this->create($itemInput);
            } else {
                $invoiceItem = $this->update($invoiceItem->id, $itemInput);
            }
        }
    }
}
