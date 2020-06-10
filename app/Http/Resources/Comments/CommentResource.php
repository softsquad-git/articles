<?php

namespace App\Http\Resources\Comments;

use App\Helpers\Avatar;
use App\Http\Resources\Users\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
        $data['user'] = [
          'avatar' => Avatar::src($this->user_id),
          'name' => $this->user->specificData->name . ' ' . $this->user->specificData->last_name
        ];
        $data['c_answers'] = count($this->answers);

        return $data;
    }
}
