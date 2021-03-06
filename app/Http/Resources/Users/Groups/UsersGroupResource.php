<?php

namespace App\Http\Resources\Users\Groups;

use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersGroupResource extends JsonResource
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

        return $data;
    }
}
