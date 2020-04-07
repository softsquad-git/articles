<?php

namespace App\Models\Articles;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ImagesArticle extends Model
{
    protected $table = 'article_images';

    protected $fillable = [
        'user_id',
        'article_id',
        'src'
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
