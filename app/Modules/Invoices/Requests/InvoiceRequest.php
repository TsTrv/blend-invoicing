<?php

namespace App\Modules\Invoices\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class InvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'issued_date' => ['required'],
            'client_id' => ['required', 'exists:clients,id']
        ];

        if (preg_match('/update/', Route::currentRouteName())) {
            $rules = $rules + [
                'currency_code' => ['required'],
                'status_id' => ['required'],
                'due_date' => ['required'],
                'number' => ['required'],
                'item.price.*' => ['required'],
                'item.quantity.*' => ['required'],
            ];
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'client_id.required' => 'The client field is required.',
            'item.price.*.required' => 'The price field is required.',
            'item.quantity.*.required' => 'The quantity field is required.',
            'currency_code.required' => 'The currency field is required.',
            'status_id.required' => 'The status field is required.',
            'due_date.required' => 'The due date field is required.',
            'issued_date.required' => 'The date issued field is required.',
            'number.required' => 'The invoice number is required.'
        ];

        return $messages;
    }
}
