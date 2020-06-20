<?php

namespace App\Http\Requests\Users\Experts;

use Illuminate\Foundation\Http\FormRequest;

class ExpertRequest extends FormRequest
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
            'category_id' => 'required|integer',
            'description' => 'required|min:10|max:1000',
            'additional_info' => 'nullable'
        ];
    }
}
