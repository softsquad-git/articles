<?php

namespace App\Http\Resources\Users\Groups;

use App\Services\User\Groups\GroupsPostsService;
use Illuminate\Http\Resources\Json\JsonResource;

class PostsImagesGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'src' => asset(GroupsPostsService::GROUP_POST_IMAGES_PATH.$this->src)
        ];
    }
}
