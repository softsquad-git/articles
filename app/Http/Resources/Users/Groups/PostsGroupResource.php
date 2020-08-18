<?php

namespace App\Http\Resources\Users\Groups;

use App\Http\Resources\Users\UserResource;
use App\Services\User\Groups\GroupsPostsService;
use Illuminate\Http\Resources\Json\JsonResource;

class PostsGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $images = [];
        foreach ($this->images as $image) {
            $images[] = asset(GroupsPostsService::GROUP_POST_IMAGES_PATH.$image->src);
        }
        $data = parent::toArray($request);
        $data['user'] = new UserResource($this->user);
        $data['images'] = $images;
        $data['c_likes_down'] = $this->likes()->where('like', 0)->count();
        $data['c_likes_up'] = $this->likes()->where('like', 1)->count();
        $data['c_comments'] = $this->comments->count();

        return $data;
    }
}
