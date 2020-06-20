<?php

namespace App\Models\Categories;

use App\Models\Articles\Article;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'status',
        'icon',
        'alias'
    ];

    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id');
    }

    public function experts()
    {
        return $this->belongsToMany(User::class, 'experts', 'user_id', 'category_id');
    }
}
