<?php

namespace App\Http\Resources\Friends;

use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FriendResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data['id'] = $this->id;
        $data['status'] = $this->status;
        $data['friends'] = new UserResource($this->recipient ?? $this->sender);
        return $data;

    }
}
