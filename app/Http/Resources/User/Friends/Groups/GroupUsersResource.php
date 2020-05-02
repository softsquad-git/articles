<?php

namespace App\Http\Resources\User\Friends\Groups;

use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupUsersResource extends JsonResource
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
        $data['group'] = [
            'name' => $this->group->name,
            'description' => $this->group->description,
            'created_at' => $this->group->created_at
        ];

        return $data;
    }
}
