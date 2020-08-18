<?php

namespace App\Services\User\Groups;

use App\Helpers\GroupStatus;
use App\Models\Users\Groups\PostsGroup;
use App\Models\Users\Groups\PostsGroupImages;
use App\Models\Users\Groups\UsersGroup;
use App\Repositories\User\Groups\GroupsPostsRepository;
use App\Repositories\User\Groups\GroupsRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GroupsPostsService
{
    const GROUP_POST_IMAGES_PATH = 'assets/data/user/groups/images/';
    const RESOURCE_TYPE = 'POST_GROUP';
    /**
     * @var GroupsRepository
     */
    private $groupsRepository;

    /**
     * @var GroupsPostsRepository
     */
    private $groupsPostsRepository;

    /**
     * GroupsPostsService constructor.
     * @param GroupsRepository $groupsRepository
     * @param GroupsPostsRepository $groupsPostsRepository
     */
    public function __construct(GroupsRepository $groupsRepository, GroupsPostsRepository $groupsPostsRepository)
    {
        $this->groupsRepository = $groupsRepository;
        $this->groupsPostsRepository = $groupsPostsRepository;
    }

    /**
     * @param array $data
     * @return PostsGroup
     * @throws \Exception
     */
    public function store(array $data): PostsGroup
    {
        $data['user_id'] = Auth::id();
        $group = $this->groupsRepository->findGroup($data['group_id']);
        if (empty($group))
            throw new \Exception(sprintf('Group %d not found', $data['group_id']));
        if ($group->is_accept_post === 1)
            $data['status'] = GroupStatus::POST_STATUS_WAITING;
        $post = PostsGroup::create($data);
        if (empty($post))
            throw new \Exception('Something went wrong');
        return $post;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function update(array $data, int $id)
    {
        $item = $this->groupsPostsRepository->findGroupPost($id);
        if (empty($item))
            throw new \Exception(sprintf('Post %d not found in this group', $id));
        $item->update($data);
        return $item;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function remove(int $id)
    {
        $item = $this->groupsPostsRepository->findGroupPost($id);
        if (empty($item))
            throw new \Exception(sprintf('Post %d not found in this group', $id));
        return $item->delete();
    }

    /**
     * @param array $images
     * @param int $groupId
     * @return array|bool
     */
    public function uploadPostImages(array $images, int $groupId)
    {
        try {
            $articles = [];
            $b_path = GroupsPostsService::GROUP_POST_IMAGES_PATH;
            foreach ($images as $image) {
                $file_name = md5(time() . Str::random(32)) . '.' . $image->getClientOriginalExtension();
                $image->move($b_path, $file_name);
                $article = PostsGroupImages::create([
                    'user_id' => Auth::id(),
                    'post_id' => $groupId,
                    'src' => $file_name
                ]);

                $articles[] = $article;
            }

            return $articles;
        } catch (\Exception $e) {
            Log::error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return false;
        }
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws \Exception
     */
    public function removePostImage(int $id): ?bool
    {
        $item = $this->groupsPostsRepository->findImagePost($id);
        if (empty($item))
            throw new \Exception(sprintf('Image %d not found', $id));
        return $item->delete();
    }

    /**
     * @param int $postId
     * @return bool|null
     * @throws \Exception
     */
    public function acceptPost(int $postId): ?bool
    {
        $post = $this->groupsPostsRepository->findGroupPost($postId);
        $user = UsersGroup::where([
            'user_id' => Auth::id(),
            'group_id' => $post->group_id
        ])->first();
        if($user->is_admin != 1)
            throw new \Exception('Nie masz prawa dostępu');
        return $post->update(['status' => 1]);
    }

}
