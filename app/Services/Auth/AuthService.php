<?php

namespace App\Services\Auth;

use App\Helpers\UpdateStatusUser;
use App\Helpers\VerifyEmail;
use App\Models\Users\SpecificData;
use App\Repositories\User\UserRepository;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $dataUser
     * @param array $dataSpecificUser
     * @return User
     */
    public function register(array $dataUser, array $dataSpecificUser): User
    {
        $dataUser['password'] = Hash::make($dataUser['password']);
        $user = User::create($dataUser);

        $dataSpecificUser['user_id'] = $user->id;
        SpecificData::create($dataSpecificUser);

        VerifyEmail::verify($user->id);

        return $user;
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function activate(array $data)
    {
        $key = $data['_key'];
        if (VerifyEmail::checkKeys($key)) {
            UpdateStatusUser::setActivateUser(1);
            return true;
        }
        throw new \Exception('Entered key invalid');
    }

    /**
     * @return mixed|string
     */
    public function refreshKeyActivate()
    {
        try {
            return VerifyEmail::updateKey();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
