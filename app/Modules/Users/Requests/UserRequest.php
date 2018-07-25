<?php

namespace App\Modules\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class UserRequest extends FormRequest
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
        $user = $this->route('user');

        $rules = [
            'name' => ['required'],
            'email' => ['required', 'unique:users,email,'.$user],
            'company' => ['required']
        ];
        return $rules;
    }
}
