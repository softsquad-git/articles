<?php

namespace App\Services\User\Photos;

use App\Models\Users\Photos\AlbumPhotos;
use App\Repositories\User\Photos\AlbumPhotosRepository;
use Illuminate\Support\Facades\Auth;
use \Exception;

class AlbumPhotosService
{
    /**
     * @var AlbumPhotosRepository
     */
    private $albumPhotosRepository;

    /**
     * @param AlbumPhotosRepository $albumPhotosRepository
     */
    public function __construct(AlbumPhotosRepository $albumPhotosRepository)
    {
        $this->albumPhotosRepository = $albumPhotosRepository;
    }

    /**
     * @param array $data
     * @return AlbumPhotos
     * @throws Exception
     */
    public function store(array $data): AlbumPhotos
    {
        $data['user_id'] = Auth::id();
        $item = AlbumPhotos::create($data);
        if (empty($item))
            throw new \Exception(sprintf('Try again'));
        return $item;
    }

    /**
     * @param array $data
     * @param int $id
     * @return AlbumPhotos
     * @throws Exception
     */
    public function update(array $data, int $id): AlbumPhotos
    {
        $item = $this->albumPhotosRepository->findAlbum($id);
        $item->update($data);
        return $item;
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws Exception
     */
    public function remove(int $id): ?bool
    {
        $item = $this->albumPhotosRepository->findAlbum($id);
        return $item->delete();
    }

}
