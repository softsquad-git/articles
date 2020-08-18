<?php

namespace App\Http\Resources\User\Experts;

use Illuminate\Http\Resources\Json\JsonResource;

class OpinionsExpertsResource extends JsonResource
{
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['article_title'] = $this->article->title;
        $data['user'] = [
            'id' => $this->expert->user->id,
            'name' => $this->expert->user->specificData->name . ' ' . $this->expert->user->specificData->last_name
        ];
        return $data;
    }
}
