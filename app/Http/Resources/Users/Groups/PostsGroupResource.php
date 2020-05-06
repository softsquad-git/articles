<?php

namespace App\Http\Resources\Users\Groups;

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
        return parent::toArray($request);
    }
}
