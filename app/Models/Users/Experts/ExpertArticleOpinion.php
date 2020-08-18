<?php

namespace App\Models\Users\Experts;

use App\Models\Articles\Article;
use Illuminate\Database\Eloquent\Model;

class ExpertArticleOpinion extends Model
{
    protected $table = 'article_opinions_expert';

    protected $fillable = [
        'expert_id',
        'article_id',
        'content'
    ];

    public function expert()
    {
        return $this->belongsTo(Expert::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
