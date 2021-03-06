<?php

namespace App\Http\Resources\Users;

use App\Helpers\Avatar;
use App\Helpers\FriendshipStatus;
use App\Helpers\Status;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
        $data['avatar'] = Avatar::src($this->id);
        $data['s'] = $this->specificData;
        $data['articles'] = $this->articles->count();
        $data['photos'] = $this->photos->count();
        $data['friends'] = $this->friends()->where('status', FriendshipStatus::FRIENDS)->count();

        return $data;
    }
}
