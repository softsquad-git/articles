<?php


namespace App\Services\ADMIN\Users;

use \Exception;
use App\Repositories\ADMIN\Users\UserRepository;

class UserService
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
     * @param int $value
     * @return int
     * @throws Exception
     */
    private function validValue(int $value)
    {
        if ($value < 0 || $value > 1)
            throw new Exception('Podane nieprawidłowe dane');
        return $value;
    }

    /**
     * @param int $value
     * @param int $userId
     * @return mixed
     * @throws Exception
     */
    public function changeActivated(int $value, int $userId)
    {
        $value = $this->validValue($value);
        $user = $this->userRepository->findUser($userId);
        $user->update([
            'activated' => $value
        ]);
        return $user;
    }

    /**
     * @param int $value
     * @param int $userId
     * @return mixed
     * @throws Exception
     */
    public function changeLocked(int $value, int $userId)
    {
        $value = $this->validValue($value);
        $user = $this->userRepository->findUser($userId);
        $user->update([
            'locked' => $value
        ]);
        return $user;
    }
}
