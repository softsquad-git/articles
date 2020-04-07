<?php

namespace App\Http\Resources\Articles;

use App\Helpers\ArticleImage;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['image'] = ArticleImage::topImage($this->images->first());

        return $data;
    }
}
