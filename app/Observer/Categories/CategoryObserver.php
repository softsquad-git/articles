<?php

namespace App\Observer\Categories;

use App\Models\Categories\Category;

class CategoryObserver
{
    public function deleting(Category $category)
    {
        $category->articles()->delete();
    }
}
