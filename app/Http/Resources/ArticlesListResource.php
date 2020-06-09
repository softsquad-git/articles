<?php

namespace App\Http\Resources;

use App\Helpers\ArticleImage;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticlesListResource extends JsonResource
{

    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['image'] = ArticleImage::topImage($this->images->first());
        $data['category'] = [
            'id' => $this->category_id,
            'name' => $this->category->name
        ];
        $data['user'] = [
            'id' => $this->user_id,
            'name' => $this->user->specificData->name
        ];
        $data['content'] = substr($this->content, 0, 150);
        $data['c_comments'] = $this->comments()->count();
        return $data;
    }
}
