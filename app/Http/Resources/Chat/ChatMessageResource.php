<?php

namespace App\Http\Resources\Chat;

use App\Helpers\Avatar;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource
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
        $data['sender_fullname'] = $this->sender->specificData->name . ' ' . $this->sender->specificData->last_name;
        $data['sender_avatar'] = Avatar::src($this->sender_id);
        $data['recipient_fullname'] = $this->recipient->specificData->name . ' ' . $this->recipient->specificData->last_name;
        $data['recipient_avatar'] = Avatar::src($this->recipient_id);
        return $data;
    }
}
