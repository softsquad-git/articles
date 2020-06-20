<?php

namespace App\Models\Users\Experts;

use App\Models\Categories\Category;
use App\User;
use Illuminate\Database\Eloquent\Model;

class  Expert extends Model
{
    protected $table = 'experts';

    protected $fillable = [
        'user_id',
        'category_id',
        'status'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class, 'id', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function opinions()
    {
        return $this->hasMany(ExpertArticleOpinion::class, 'expert_id');
    }
}
