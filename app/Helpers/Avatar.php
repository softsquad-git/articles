<?php

namespace App\Helpers;

use App\Models\Users\SpecificData;

class Avatar
{
    const PATH = 'assets/data/avatars/';
    const SEX_MALE = 'MALE';
    const SEX_FEMALE = 'FEMALE';

    public static function src($user_id)
    {
        $avatar = \App\Models\Users\Avatar::where('user_id', $user_id)->first();
        if (!empty($avatar)) {
            return asset(Avatar::PATH . $avatar->src);
        }
        $user = SpecificData::where('user_id', $user_id)->first();
        if (!empty($user) && !empty($user->sex)) {
            $sex = $user->sex;
            if ($sex === Avatar::SEX_MALE) {
                return asset(Avatar::PATH . 'df_male.png');
            } elseif ($sex === Avatar::SEX_FEMALE) {
                return asset(Avatar::PATH . 'df_female.png');
            }
        }
        return asset(Avatar::PATH . 'df.png');
    }

}
