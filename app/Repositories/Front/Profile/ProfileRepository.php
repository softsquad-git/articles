<?php

namespace App\Repositories\Front\Profile;

use App\Models\Articles\Article;
use \Exception;
use App\Repositories\User\Photos\AlbumPhotosRepository;
use App\Services\User\Photos\PhotosService;
use App\User;

class ProfileRepository
{
    /**
     * @var AlbumPhotosRepository
     */
    private $albumPhotosRepository;

    public function __construct(AlbumPhotosRepository $albumPhotosRepository)
    {
        $this->albumPhotosRepository = $albumPhotosRepository;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public function findUser(int $id)
    {
        $user = User::find($id);
        if (empty($user))
            throw new \Exception(sprintf('Users not found'));
        return $user;
    }

    /**
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function articles(array $params)
    {
        $userId = $params['user_id'];
        if (empty($userId))
            throw new \Exception(sprintf('Users not found. Refresh page please'));
        $title = $params['title'];
        $category_id = $params['category_id'];
        $items = Article::where('user_id', $userId)
            ->orderBy('id', 'DESC');
        if (!empty($title))
            $items->where('title', 'like', '%' . $title . '%');
        if (!empty($category_id))
            $items->where('category_id', $category_id);
        return $items
            ->paginate(20);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public function albums(int $id)
    {
        $user = $this->findUser($id);
        return $user->albums;
    }

    /**
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function photos(int $id)
    {
        $album = $this->albumPhotosRepository->find($id);
        $allImages = $album->photos;
        $images = [];
        foreach ($allImages as $img) {
            $images[] = asset(PhotosService::PATH_PHOTOS . $img->src);
        }
        return $images;
    }

}
