<?php

namespace App\Models\Articles;

use App\User;
use Illuminate\Database\Eloquent\Model;

class RatingArticle extends Model
{
    protected $table = 'ratings_article';

    protected $fillable = [
        'user_id',
        'article_id',
        'points'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
