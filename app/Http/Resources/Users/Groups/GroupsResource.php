<?php

namespace App\Http\Resources\Users\Groups;

use App\Repositories\Front\Groups\GroupRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use \Illuminate\Http\Request;

class GroupsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['is_belong'] = GroupRepository::checkBelongGroup($this->id);
        $data['is_admin'] = GroupRepository::checkAdminGroup($this->id);
        return $data;
    }
}
