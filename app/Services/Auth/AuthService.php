<?php

namespace App\Services\Auth;

use App\Helpers\VerifyEmail;
use App\Models\Users\SpecificData;
use App\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    public function register(array $dataUser, array $dataSpecificUser): User
    {
        $dataUser['password'] = Hash::make($dataUser['password']);
        $user = User::create($dataUser);

        $dataSpecificUser['user_id'] = $user->id;
        SpecificData::create($dataSpecificUser);

        VerifyEmail::verify($user->id);

        return $user;
    }

}
