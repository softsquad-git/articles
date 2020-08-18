<?php

namespace App\Helpers;

use App\Models\Users\SpecificData;

class Avatar
{
    const SEX_MALE = 'MALE';
    const SEX_FEMALE = 'FEMALE';

    /**
     * @param int $userId
     * @return string
     */
    public static function src(int $userId): string
    {
        $avatarPath = config('app.enum.defaults.paths.avatar');
        $avatar = \App\Models\Users\Avatar::where('user_id', $userId)->first();
        if (!empty($avatar)) {
            return asset($avatarPath . $avatar->src);
        }
        $user = SpecificData::where('user_id', $userId)->first();
        if (!empty($user) && !empty($user->sex)) {
            $sex = $user->sex;
            if ($sex === Avatar::SEX_MALE) {
                return asset($avatarPath . config('app.enum.defaults.filenames.sex.male'));
            } elseif ($sex === Avatar::SEX_FEMALE) {
                return asset($avatarPath . config('app.enum.defaults.filenames.sex.female'));
            }
        }
        return asset($avatarPath . config('app.enum.defaults.filenames.avatar'));
    }

}
