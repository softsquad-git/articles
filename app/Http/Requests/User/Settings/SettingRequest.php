<?php

namespace App\Http\Requests\User\Settings;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
        return [
            'name' => 'string|min:3',
            'last_name' => 'string|min:3',
            'birthday' => 'date|date_format:Y-m-d',
            'number_phone' => 'nullable|string',
            'city' => 'nullable|string|min:3',
            'post_code' => 'nullable|string',
            'address' => 'nullable|string',
            'sex' => 'string'
        ];
    }
}
