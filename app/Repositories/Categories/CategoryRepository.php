<?php

namespace App\Repositories\Categories;

use App\Models\Categories\Category;

class CategoryRepository
{

    public function items(array $search)
    {
        $name = $search['name'];

        $items = Category::orderBy('id', 'DESC');
        if (!empty($name))
            $items->where('name', 'like', '%' . $name . '%');

        return $items
            ->paginate(20);
    }

    public function all()
    {
        return Category::all();
    }

    public function findCategory(int $id)
    {
        return Category::find($id);
    }

}
