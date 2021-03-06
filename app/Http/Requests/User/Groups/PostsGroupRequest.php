<?php

namespace App\Http\Requests\User\Groups;

use Illuminate\Foundation\Http\FormRequest;

class PostsGroupRequest extends FormRequest
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
            'group_id' => 'required|integer',
            'content' => 'required|min:3',
            'images' => 'nullable|array'
        ];
    }
}
