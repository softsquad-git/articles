<?php

namespace App\Repositories\Comments;

use App\Models\Comments\Comment;

class CommentRepository
{

    public function items(array $params)
    {
        $resource_id = $params['resource_id'];
        $resource_type = $params['resource_type'];
        if (!empty($resource_id) && !empty($resource_type)) {
            return Comment::where([
                'resource_id' => $resource_id,
                'resource_type' => $resource_type
            ])->orderBy('id', 'DESC')
                ->paginate(20);
        }

        return false;
    }

    public function find($id)
    {
        return Comment::find($id);
    }

}
