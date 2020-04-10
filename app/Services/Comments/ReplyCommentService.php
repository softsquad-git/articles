<?php

namespace App\Services\Comments;

use App\Models\Comments\ReplyComment;
use Illuminate\Support\Facades\Auth;

class ReplyCommentService
{

    public function store(array $data): ReplyComment
    {
        $parent_id = $data['parent_id'];
        if (empty($parent_id))
            $parent_id = 0;
        $data['parent_id'] = $parent_id;
        $data['user_id'] = Auth::id();
        $item = ReplyComment::create($data);

        return $item;
    }

    public function update(array $data, ReplyComment $item): ReplyComment
    {
        $item->update($data);

        return $item;
    }

    public function remove(ReplyComment $item)
    {
        $item->delete();

        return true;
    }

}
