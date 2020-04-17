<?php

namespace App\Repositories\User\Settings;

use App\Models\Users\ChangeEmail;
use App\User;
use Illuminate\Support\Facades\Auth;

class SettingRepository
{

    public function findUser()
    {
        return User::find(Auth::id());
    }

    public function findSpecificDataUser()
    {
        return $this->findUser()->s;
    }

    public function findTmpChangeEmail()
    {
        return ChangeEmail::where('user_id', Auth::id())
            ->first();
    }

}
