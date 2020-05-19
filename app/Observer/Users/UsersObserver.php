<?php

namespace App\Observer\Users;

use App\User;

class UsersObserver
{

    public function deleting(User $user)
    {
        $user->specificData()->delete();
        $user->avatar()->delete();
        $user->albums()->delete();
        $user->follows()->delete();
        $user->likes()->delete();
        $user->articles()->delete();
        $user->friends()->delete();
        $user->photos()->delete();
    }

}
