<?php

namespace App\Http\Resources\Chat;

use App\Helpers\Avatar;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['name'] = $this->user->specificData->name;
        $data['avatar'] = Avatar::src($this->sender_id);
        return $data;
    }
}
