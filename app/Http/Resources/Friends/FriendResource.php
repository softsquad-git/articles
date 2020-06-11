<?php

namespace App\Http\Resources\Friends;

use App\Helpers\Avatar;
use Illuminate\Http\Resources\Json\JsonResource;

class FriendResource extends JsonResource
{
    public function toArray($request)
    {
        $user = $this->recipient ?? $this->sender;
        $data['id'] = $this->id;
        $data['status'] = $this->status;
        $data['user'] = [
            'id' => $user->id,
            'name' => $user->specificData->name . ' ' . $user->specificData->last_name,
            'avatar' => Avatar::src($user->id)
        ];
        $data['created_at'] = (string)$this->created_at;
        return $data;

    }
}
