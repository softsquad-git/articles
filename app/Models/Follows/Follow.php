<?php

namespace App\Models\Follows;

use App\Models\Articles\Article;
use App\Services\User\Articles\ArticleService;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $table = 'follows';

    protected $fillable = [
        'user_id',
        'resource_id',
        'resource_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
