<?php

namespace App\Repositories\User\Settings;

use App\Models\Users\Avatar;
use App\Models\Users\ChangeEmail;
use App\Models\Users\ChangePassword;
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
        return $this->findUser()->specificData;
    }

    public function findTmpChangeEmail()
    {
        return ChangeEmail::where('user_id', Auth::id())
            ->first();
    }

    public function findAvatarUser()
    {
        return Avatar::where('user_id', Auth::id())
            ->first();
    }

}
