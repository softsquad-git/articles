<?php

namespace App\Http\Resources\Chat;

use App\Helpers\Avatar;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Http\Request;

class ChatResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['b_name'] = Auth::id() == $this->sender_id
            ? $this->recipient->specificData->name . ' ' .$this->recipient->specificData->last_name
            : $this->sender->specificData->name . ' ' . $this->sender->specificData->last_name;
        $data['avatar'] = Auth::id() == $this->sender_id
            ? Avatar::src($this->recipient_id)
            : Avatar::src($this->sender_id);
        return $data;
    }
}
