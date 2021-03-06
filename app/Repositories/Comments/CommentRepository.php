<?php

namespace App\Repositories\Comments;

use App\Models\Comments\Comment;
use \Exception;

class CommentRepository
{

    /**
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function getComments(array $params)
    {
        if (empty($params['resource_id']) || empty($params['resource_type']))
            throw new \Exception(sprintf('Refresh page and try again'));
        return Comment::where([
            'resource_id' => $params['resource_id'],
            'resource_type' => $params['resource_type']
        ])->orderBy('id', $params['ordering'] ?? 'DESC')
            ->paginate(20);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public function findComment(int $id)
    {
        $comment = Comment::find($id);
        if (empty($comment))
            throw new Exception('Comment not found');
        return $comment;
    }

}
