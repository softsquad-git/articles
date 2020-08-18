<?php

namespace App\Repositories\Categories;

use App\Helpers\Status;
use App\Models\Articles\Article;
use App\Repositories\Front\Articles\ArticleRepository;
use \Exception;
use App\Models\Categories\Category;
use \Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * CategoryRepository constructor.
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param array $search
     * @return mixed
     */
    public function getCategories(array $search)
    {
        $name = $search['name'];
        $items = Category::orderBy('id', 'DESC');
        if (!empty($name))
            $items->where('name', 'like', '%' . $name . '%');
        return $items
            ->paginate(20);
    }

    /**
     * @return Category[]|Collection
     */
    public function getAllCategories()
    {
        return Category::all();
    }

    /**
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public function findCategory(int $id)
    {
        $category = Category::find($id);
        if (empty($category))
            throw new Exception('Category not found');
        return $category;
    }

    /**
     * @param string $alias
     * @return mixed
     * @throws Exception
     * @param array $params
     */
    public function articlesInCategory(string $alias, array $params)
    {
        $category = Category::where('alias', $alias)->first();
        if (empty($category))
            throw new Exception('Category not found');
        $categoryId = $category->id;
        $params['category'] = $categoryId;
        return $this->articleRepository->getArticles($params);
    }

    /**
     * @param array $ids
     * @return mixed
     */
    public function getFewCategories(array $ids)
    {
        return Category::whereIn('id', $ids)
            ->where('status', 1)
            ->get();
    }

}
