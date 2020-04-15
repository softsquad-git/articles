<?php

namespace App\Http\Requests\Front\Articles;

use Illuminate\Foundation\Http\FormRequest;

class RatingArticleRequest extends FormRequest
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
            'article_id' => 'required|integer',
            'points' => 'required|integer|min:1|max:10'
        ];
    }
}
