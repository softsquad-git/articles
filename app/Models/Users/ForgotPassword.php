<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class ForgotPassword extends Model
{
    protected $table = 'forgot_password';

    protected $fillable = [
        'email',
        '_key'
    ];
}
