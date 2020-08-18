<?php

namespace App\Services\ADMIN\Categories;

use App\Repositories\ADMIN\Categories\CategoryRepository;
use \Exception;
use App\Models\Categories\Category;

class CategoryService
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * CategoryService constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function store(array $data)
    {
        $category = Category::create($data);
        if (empty($category))
            throw new Exception('Nie udało się dodać kategorii');
        return $category;
    }

    /**
     * @param array $data
     * @param int $categoryId
     * @return mixed
     * @throws Exception
     */
    public function update(array $data, int $categoryId)
    {
        $category = $this->categoryRepository->findCategory($categoryId);
        $category->update($data);
        return $category;
    }

    /**
     * @param int $categoryId
     * @return bool|null
     * @throws Exception
     */
    public function remove(int $categoryId): ?bool
    {
        $category = $this->categoryRepository->findCategory($categoryId);
        return $category->delete();
    }
}
