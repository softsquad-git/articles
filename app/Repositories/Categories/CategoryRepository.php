<?php

namespace App\Repositories\Categories;

use \Exception;
use App\Models\Categories\Category;
use \Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{

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

}
