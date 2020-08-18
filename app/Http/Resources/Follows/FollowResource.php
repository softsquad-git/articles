<?php

namespace App\Http\Resources\Follows;

use App\Helpers\ArticleImage;
use App\Http\Resources\Articles\ArticleResource;
use App\Http\Resources\ArticlesListResource;
use App\Http\Resources\Users\UserResource;
use App\Models\Articles\Article;
use App\Services\User\Articles\ArticleService;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class FollowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];
        $data['id'] = $this->id;
        if ($this->resource_type == ArticleService::RESOURCE_TYPE){
            $data['article'] = new ArticlesListResource(Article::find($this->resource_id));
        } elseif ($this->resource_type == 'USER'){
            $data['user'] = new UserResource(User::find($this->resource_id == Auth::id() ? $this->user_id : $this->resource_id));
        }
        return $data;
    }
}
