<?php

namespace App\Modules\Timelogs\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class TimelogRequest extends FormRequest
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
            'user_id' => ['required',  'exists:users,id'],
            'project_id' => ['required', 'exists:projects,id'],
            'description' => ['required'],
            'total' => ['required'],
            'date' => ['required']
        ];
        return $rules;
    }
}
