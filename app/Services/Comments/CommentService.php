<?php

namespace App\Services\Comments;

use App\Models\Comments\Comment;
use Illuminate\Support\Facades\Auth;

class CommentService
{

    public function store(array $data): Comment
    {
        $data['user_id'] = Auth::id();
        $item = Comment::create($data);

        return $item;
    }

    public function update(array $data, Comment $item): Comment
    {
        $item->update($data);

        return $item;
    }

    public function remove(Comment $item)
    {
        $item->delete();

        return true;
    }

}
