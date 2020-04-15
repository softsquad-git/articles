<?php

namespace App\Http\Resources\Articles;

use App\Helpers\ArticleImage;
use App\Http\Resources\Categories\CategoryResource;
use App\Http\Resources\Users\UserResource;
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
        $data['category'] = new CategoryResource($this->category);
        $data['user'] = new UserResource($this->user);
        $data['follows'] = count($this->follows);
        $data['like_up'] = count($this->likes->where('like', 1));
        $data['like_down'] = count($this->likes->where('like', 0));
        return $data;
    }
}
