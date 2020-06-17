<?php

namespace App\Services\User\Articles;

use App\Helpers\Status;
use App\Helpers\Upload;
use App\Models\Articles\Article;
use App\Models\Articles\ImagesArticle;
use App\Repositories\User\Articles\ArticleRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use \Exception;

class ArticleService
{
    const IMAGES_ARTICLE_PATH = 'assets/data/articles/images/';
    const IMAGES_ARTICLE_EDITOR_PATH = 'assets/data/articles/wysywig/';
    const RESOURCE_TYPE = 'ARTICLE';

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * ArticleService constructor.
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param array $data
     * @return Article
     * @throws Exception
     */
    public function store(array $data): Article
    {
        $data['user_id'] = Auth::id();
        $item = Article::create($data);
        if (empty($item))
            throw new Exception(sprintf('Try again'));
        return $item;
    }

    /**
     * @param array $data
     * @param int $id
     * @return Article
     * @throws Exception
     */
    public function update(array $data, int $id): Article
    {
        $item = $this->articleRepository->find($id);
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
        return $this->articleRepository->find($id)->delete();
    }

    /**
     * @param int $article_id
     * @param $image
     * @return bool
     * @throws Exception
     */
    public function uploadImage(int $article_id, $image)
    {
        $article = $this->articleRepository->find($article_id);
        if (empty($article))
            throw new Exception(sprintf('Article not found'));
        $images = ImagesArticle::where([
            'article_id' => $article_id,
            'user_id' => Auth::id()
        ])->get();
        if (count($images) > 0) {
            foreach ($images as $image) {
                $image->delete();
            }
        }
        $fileName = Upload::singleFile(ArticleService::IMAGES_ARTICLE_PATH, $image);
        try {
            ImagesArticle::create([
                'user_id' => Auth::id(),
                'article_id' => $article_id,
                'src' => $fileName
            ]);
        } catch (Exception $e) {
            throw new Exception('Upload file error');
        }
        return true;
    }

    /**
     * @param int $id
     * @return Article
     * @throws Exception
     */
    public function archive(int $id): Article
    {
        $item = $this->articleRepository->find($id);
        if (empty($item))
            throw new Exception(sprintf('Article not found'));
        if ($item->status == Status::ARTICLE_IMPROVE
            || $item->status == Status::ARTICLE_LOCKED
            || $item->status == Status::ARTICLE_NEW) {
            throw new Exception('Forbidden');
        }
        if ($item->status == Status::ARTICLE_ARCHIVE) {
            $item->update([
                'status' => Status::ARTICLE_PUBLISHED
            ]);
            return $item;
        }
        $item->update([
            'status' => Status::ARTICLE_ARCHIVE
        ]);
        return $item;
    }

    /**
     * @param $file
     * @return string
     */
    public function uploadImageEditor($file)
    {
        $b_path = ArticleService::IMAGES_ARTICLE_EDITOR_PATH;
        $file_name = md5(time() . Str::random(32)) . '.' . $file->getClientOriginalExtension();
        $file->move($b_path, $file_name);
        return asset($b_path . $file_name);
    }


}
