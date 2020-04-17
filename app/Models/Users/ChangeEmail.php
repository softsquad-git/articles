<?php

namespace App\Models\Users;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ChangeEmail extends Model
{
    protected $table = 'change_email';

    protected $fillable = [
        'user_id',
        '_key',
        'tmp_email'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
