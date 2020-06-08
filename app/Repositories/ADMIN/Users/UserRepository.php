<?php

namespace App\Repositories\ADMIN\Users;

use App\User;
use Illuminate\Support\Facades\DB;
use \Exception;

class UserRepository
{
    public function getUsers(array $params)
    {
        $name = $params['name'];
        $activated = $params['activated'];
        $locked = $params['locked'];
        $sex = $params['sex'];
        $users = User::orderBy('id', 'DESC')
            ->where('r_role', '!=', 2);
        if (!empty($name)) {
            $users->whereHas('specificData', function ($q) use ($name) {
                $q->where(DB::raw("CONCAT(`name`, ' ', `last_name`)"), 'LIKE', "%" . $name . "%");
            });
        }
        if (!empty($activated))
            $users->where('activated', $activated);
        if (!empty($locked))
            $users->where('locked', $locked);
        if (!empty($sex)) {
            $users->whereHas('specificData', function ($q) use ($sex) {
                $q->where('sex', $sex);
            });
        }
        return $users->paginate(20);
    }

    /**
     * @param int $userId
     * @return mixed
     * @throws Exception
     */
    public function findUser(int $userId)
    {
        $user = User::find($userId);
        if (empty($user))
            throw new Exception('Brak danego użytkownika');
        return $user;
    }
}
