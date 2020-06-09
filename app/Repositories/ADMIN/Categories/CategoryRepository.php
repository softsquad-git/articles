<?php

namespace App\Repositories\ADMIN\Categories;

use App\Models\Categories\Category;
use \Exception;

class CategoryRepository
{
    /**
     * @param array $params
     * @return mixed
     */
    public function getCategories(array $params)
    {
        $name = $params['name'];
        $categories = Category::orderBy('id', 'DESC');
        if (!empty($categories))
            $categories->where('name', 'like', '%' . $name . '%');
        return $categories->paginate(20);
    }

    /**
     * @param int $categoryId
     * @return mixed
     * @throws Exception
     */
    public function findCategory(int $categoryId)
    {
        $category = Category::find($categoryId);
        if (empty($category))
            throw new Exception('Brak takiej kategorii');
        return $category;
    }
}
