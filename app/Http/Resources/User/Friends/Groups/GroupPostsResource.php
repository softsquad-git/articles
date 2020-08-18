<?php

namespace App\Http\Resources\User\Friends\Groups;

use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupPostsResource extends JsonResource
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
        $data['user'] = new UserResource($this->user);
        $data['c_likes_up'] = count($this->likes->where('like', 1));
        $data['c_likes_down'] = count($this->likes->where('like', 0));

        return $data;
    }
}
