<?php

namespace App\Http\Resources\Articles;

use App\Services\User\Articles\ArticleService;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleImagesResource extends JsonResource
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
        $data['src'] = asset(ArticleService::IMAGES_ARTICLE_PATH.$this->src);

        return $data;
    }
}
