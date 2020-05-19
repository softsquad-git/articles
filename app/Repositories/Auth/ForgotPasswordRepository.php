<?php

namespace App\Repositories\Auth;

use App\Models\Users\ForgotPassword;
use App\User;

class ForgotPasswordRepository
{
    /**
     * @param string $email
     * @return mixed
     * @throws \Exception
     */
    public function checkEmptyAccount(string $email)
    {
        $account = User::where('email', $email)
            ->first();
        if (empty($account))
            throw new \Exception('Konto o takim adresie nie istnieje');
        return $account;
    }


    public function getKey(string $email)
    {
        $key = ForgotPassword::where('email', $email)
            ->first();
        if (empty($key))
            throw new \Exception('Podany kod nie istnijee');
        return $key;
    }
}
