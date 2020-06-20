<?php

namespace App\Models\Users\Experts;

use App\Models\Categories\Category;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ExpertQuery extends Model
{
    protected $table = 'expert_query';

    protected $fillable = [
        'user_id',
        'category_id',
        'description',
        'status',
        'additional_info'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
