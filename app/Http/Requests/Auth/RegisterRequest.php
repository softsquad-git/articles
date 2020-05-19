<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'name' => 'required|string|min:3',
            'last_name' => 'required|string|min:3',
            'birthday' => 'required|date|date_format:Y-m-d',
            'number_phone' => 'nullable|string',
            'city' => 'nullable|string|min:3',
            'post_code' => 'nullable|string',
            'address' => 'nullable|string',
            'sex' => 'required|string',
            'terms' => 'required|accepted'
        ];
    }
}
