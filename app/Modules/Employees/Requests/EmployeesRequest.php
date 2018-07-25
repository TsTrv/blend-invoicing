<?php

namespace App\Modules\Employees\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class EmployeesRequest extends FormRequest
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
            'roles' => ['required', 'exists:roles,id']
        ];

        if (preg_match('/create/', Route::currentRouteName())) {
            $rules = $rules + [
                'email' => ['required', 'email', 'unique:users']
            ];
        }

        return $rules;
    }
}
