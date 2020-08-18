<?php

namespace App\Http\Resources\User\Photos;

use App\Helpers\UserPhoto;
use Illuminate\Http\Resources\Json\JsonResource;

class AlbumPhotosResource extends JsonResource
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
        $data['c_images'] = count($this->photos);
        $data['intro_img'] = UserPhoto::intro($this->photos->first()->src ?? '');
        return $data;
    }
}
