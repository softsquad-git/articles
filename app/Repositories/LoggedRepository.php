<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\Auth;

class LoggedRepository
{

    public function user()
    {
        return User::find(Auth::id());
    }

}
