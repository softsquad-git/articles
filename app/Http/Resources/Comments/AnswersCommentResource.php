<?php

namespace App\Http\Resources\Comments;

use App\Helpers\Avatar;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswersCommentResource extends JsonResource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['user'] = [
            'avatar' => Avatar::src($this->user_id),
            'name' => $this->user->specificData->name . ' ' . $this->user->specificData->last_name
        ];
        return $data;
    }
}
