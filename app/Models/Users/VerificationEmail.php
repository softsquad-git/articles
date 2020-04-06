<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class VerificationEmail extends Model
{
    protected $table = 'email_verification';

    protected $fillable = [
        'user_id',
        '_key'
    ];
}
