<?php

namespace App\Models\Articles;

use App\Models\Categories\Category;
use App\Models\Comments\Comment;
use App\Models\Follows\Follow;
use App\Models\Likes\Like;
use App\Services\User\Articles\ArticleService;
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'resource_id', 'id')
            ->where('resource_type', ArticleService::RESOURCE_TYPE);
    }

    public function follows()
    {
        return $this->hasMany(Follow::class, 'resource_id', 'id')
            ->where('resource_type', ArticleService::RESOURCE_TYPE);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'resource_id', 'id')
            ->Where('resource_type', ArticleService::RESOURCE_TYPE);
    }

}
