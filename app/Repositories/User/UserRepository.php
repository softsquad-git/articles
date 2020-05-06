<?php

namespace App\Repositories\User;

use App\User;

class UserRepository
{

    public function findUser(int $id)
    {
        return User::find($id);
    }

}
