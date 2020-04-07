<?php

namespace App\Http\Requests\User\Articles;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'title' => 'required|string|min:3',
            'category_id' => 'required|integer',
            'content' => 'required',
            'is_comment' => 'required',
            'is_rating' => 'required',
            'location' => 'required'
        ];
    }
}
