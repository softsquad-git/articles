<?php

namespace App\Models\Articles;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';

    protected $fillable = [
        'user_id',
        'title',
        'category_id',
        'content',
        'location',
        'is_comment',
        'is_rating',
        'status',
        'views'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(ImagesArticle::class, 'article_id', 'id');
    }

}
