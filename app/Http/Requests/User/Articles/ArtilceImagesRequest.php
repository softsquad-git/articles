<?php

namespace App\Http\Requests\User\Articles;

use Illuminate\Foundation\Http\FormRequest;

class ArtilceImagesRequest extends FormRequest
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
            'images' => 'nullable|array'
        ];
    }
}
