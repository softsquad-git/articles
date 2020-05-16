<?php

namespace App\Helpers;

use App\User;
use Illuminate\Support\Facades\Auth;

class UpdateStatusUser
{

    public static function setActivateUser(int $value)
    {
        if (Auth::user()->activated != $value && $value == 0) {
            VerifyEmail::verify(Auth::id());
        }
        User::where('id', Auth::id())
            ->update([
                'activated' => $value
            ]);
        return true;
    }

}
