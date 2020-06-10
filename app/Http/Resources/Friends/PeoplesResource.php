<?php

namespace App\Http\Resources\Friends;

use App\Helpers\Avatar;
use Illuminate\Http\Resources\Json\JsonResource;
use \Illuminate\Http\Request;

class PeoplesResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['name'] = $this->specificData->name . ' ' . $this->specificData->last_name;
        $data['avatar'] = Avatar::src($this->id);
        return $data;
    }
}
