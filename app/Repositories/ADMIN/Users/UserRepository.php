<?php

namespace App\Repositories\ADMIN\Users;

use App\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function getUsers(array $params)
    {
        $name = $params['name'];
        $activated = $params['activated'];
        $locked = $params['locked'];
        $sex = $params['sex'];
        $users = User::orderBy('id', 'DESC');
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
}
