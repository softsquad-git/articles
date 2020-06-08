<?php

namespace App\Repositories\Front\Profile;

use App\Models\Articles\Article;
use App\Models\Users\Photos\AlbumPhotos;
use App\Models\Users\Photos\Photos;
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

    public function findUser(int $id)
    {
        $user = User::find($id);
        if (empty($user))
            throw new \Exception(sprintf('Users not found'));
        return $user;
    }

    public function articles(array $params)
    {
        $user_id = $params['user_id'];
        if (empty($user_id))
            throw new \Exception(sprintf('Users not found. Refresh page please'));
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

    public function albums(int $id)
    {
        $user = $this->findUser($id);
        if (empty($user))
            throw new \Exception(sprintf('Users not found'));
        return $user->albums;
    }

    /**
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function photos(int $id)
    {
        $album = $this->albumPhotosRepository->find($id);
        if (empty($album))
            throw new \Exception(sprintf('Album not found'));
        $allImages = $album->photos;
        $images = [];
        foreach ($allImages as $img) {
            $images[] = asset(PhotosService::PATH_PHOTOS . $img->src);
        }
        return $images;
    }

}
