<?php

namespace App\Http\Requests\User\Groups;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
            'name' => 'required|min:3|string',
            'description' => 'nullable|max:1000',
            'bg_image' => 'nullable|file',
            'type' => 'required|string',
            'is_accept_post' => 'required|boolean'
        ];
    }
}
