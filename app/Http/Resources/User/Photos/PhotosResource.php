<?php

namespace App\Http\Resources\User\Photos;

use App\Services\User\Photos\PhotosService;
use Illuminate\Http\Resources\Json\JsonResource;

class PhotosResource extends JsonResource
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
            'src' => asset(PhotosService::PATH_PHOTOS.$this->src)
        ];
    }
}
