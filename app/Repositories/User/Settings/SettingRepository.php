<?php

namespace App\Repositories\User\Settings;

use App\Models\Users\Avatar;
use App\Models\Users\ChangeEmail;
use \Exception;
use App\User;
use Illuminate\Support\Facades\Auth;

class SettingRepository
{

    /**
     * @return mixed
     * @throws Exception
     */
    public function findUser()
    {
        $user = User::find(Auth::id());
        if (empty($user))
            throw new Exception('User not found');
        return $user;

    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function findSpecificDataUser()
    {
        $user = $this->findUser();
        return $user->specificData;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function findTmpChangeEmail()
    {
        $tmpEmail = ChangeEmail::where('user_id', Auth::id())
            ->first();
        if (empty($tmpEmail))
            throw new Exception('Not found');
        return $tmpEmail;
    }

    /**
     * @return mixed
     */
    public function findAvatarUser()
    {
        return Avatar::where('user_id', Auth::id())
            ->first();
    }

}
