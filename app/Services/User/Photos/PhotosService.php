<?php

namespace App\Services\User\Photos;

use App\Models\Users\Photos\Photos;
use App\Repositories\User\Photos\AlbumPhotosRepository;
use App\Repositories\User\Photos\PhotosRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PhotosService
{
    /**
     * @var AlbumPhotosRepository
     */
    private $albumPhotosRepository;

    /**
     * @var PhotosRepository
     */
    private $photosRepository;

    /**
     * PhotosService constructor.
     * @param AlbumPhotosRepository $albumPhotosRepository
     * @param PhotosRepository $photosRepository
     */
    public function __construct(
        AlbumPhotosRepository $albumPhotosRepository,
        PhotosRepository $photosRepository
    )
    {
        $this->albumPhotosRepository = $albumPhotosRepository;
        $this->photosRepository = $photosRepository;
    }

    const PATH_PHOTOS = 'assets/data/user/photos/';

    /**
     * @param int $album_id
     * @param array $photos
     * @return array
     * @throws \Exception
     */
    public function store(int $album_id, array $photos): array
    {
        if ($album_id > 0) {
            $album = $this->albumPhotosRepository->find($album_id);
            if (empty($album))
                throw new \Exception(sprintf('Album not found'));
        }
        $photosUser = [];
        $b_path = PhotosService::PATH_PHOTOS;
        foreach ($photos as $photo){
            $file_name = md5(time() . Str::random(32)) . '.' . $photo->getClientOriginalExtension();
            $photo->move($b_path, $file_name);
            $img = Photos::create([
                'user_id' => Auth::id(),
                'album_id' => $album_id,
                'src' => $file_name
            ]);
            $photosUser[] = $img;
        }
        return $photosUser;
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws \Exception
     */
    public function remove(int $id): ?bool
    {
        $item = $this->photosRepository->find($id);
        if (empty($item))
            throw new \Exception(sprintf('Photo not found'));
        if (File::exists(PhotosService::PATH_PHOTOS.$item->src)) {
            File::delete(PhotosService::PATH_PHOTOS.$item->src);
        }
        return $item->delete();
    }

}
