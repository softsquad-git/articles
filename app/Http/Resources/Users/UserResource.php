<?php

namespace App\Http\Resources\Users;

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
        $data[] = parent::toArray($request);
        $data['avatar'] = $this->avatar->src ?? '';
        $data['s'] = $this->specificData;

        return $data;
    }
}
