<?php

namespace App\Repositories\Front\Profile;

use App\Models\Articles\Article;
use App\Models\Users\Photos\AlbumPhotos;
use App\Models\Users\Photos\Photos;
use App\User;

class ProfileRepository
{

    public function find($id)
    {
        return User::find($id);
    }

    public function articles(array $params)
    {
        $user_id = $params['user_id'];
        $title = $params['title'];
        $category_id = $params['category_id'];
        $items = Article::where('user_id', $user_id)
            ->orderBy('id', 'DESC');
        if (!empty($title))
            $items->where('title', 'like', '%' . $title . '%');
        if (!empty($category_id))
            $items->where('category_id', $category_id);
        return $items
            ->paginate(20);
    }

    public function albums(User $item)
    {
        return $item->albums;
    }

    public function photos(AlbumPhotos $item)
    {
        return $item->photos;
    }

}
