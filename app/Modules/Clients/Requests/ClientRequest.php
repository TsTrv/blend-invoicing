<?php

namespace App\Modules\Clients\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'name' => ['required'],
            'email' => ['required', 'email'],
            'address' => ['required', 'sometimes'],
            'city' => ['required', 'sometimes'],
            'postal_code' => ['required', 'sometimes'],
            'country' => ['required', 'sometimes'],
            'web' => ['required', 'sometimes'],
            'active' => ['required']
        ];

        return $rules;
    }
}
