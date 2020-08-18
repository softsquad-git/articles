<?php

namespace App\Http\Resources\User\Friends\Groups;

use App\Http\Resources\Users\UserResource;
use App\Services\User\Groups\GroupsService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class GroupResource extends JsonResource
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
        $data['bg_image'] = asset(GroupsService::BG_GROUP_PATH.$this->bg_image ?? 'df.png');
        $data['is_author'] = $this->users()->where(['user_id' => Auth::id(), 'is_author' => 1])->first() ? 1 : 0;
        $data['is_admin'] = $this->users()->where(['user_id' => Auth::id(), 'is_admin' => 1])->first() ? 1 : 0;
        return $data;
    }
}
