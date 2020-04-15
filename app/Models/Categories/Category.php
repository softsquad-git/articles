<?php

namespace App\Models\Categories;

use App\Models\Articles\Article;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name'
    ];

    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id');
    }
}