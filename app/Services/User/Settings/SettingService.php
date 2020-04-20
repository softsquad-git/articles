<?php

namespace App\Services\User\Settings;

use App\Helpers\Avatar;
use App\Helpers\VerifyEmail;
use App\Mail\User\SuccessUpdateEmailMail;
use App\Mail\User\VerifyNewEmailUserMail;
use App\Models\Users\ChangeEmail;
use App\Models\Users\SpecificData;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SettingService
{

    public function updateBasicData(array $data, SpecificData $item)
    {
        $item->update($data);
        return $item;
    }

    public function tryUpdateEmailUser(array $data, $item)
    {
        $data['_key'] = VerifyEmail::generateKey();
        if (empty($item)) {
            $data['user_id'] = Auth::id();
            $item = ChangeEmail::create($data);
            return Mail::to($item->tmp_email)->send(new VerifyNewEmailUserMail($item));
        }
        $item->update($data);
        return Mail::to($item->tmp_email)->send(new VerifyNewEmailUserMail($item));
    }

    public function updateEmailUser(ChangeEmail $tmp_item, User $item): User
    {
        $item->update(['email' => $tmp_item->tmp_email]);
        Mail::to($item->email)->send(new SuccessUpdateEmailMail());
        $tmp_item->delete();
        return $item;
    }

    public function updateAvatar($avatar, $user_avatar)
    {
        $b_path = Avatar::PATH;
        $file_name = md5(time() . Str::random(32)) . '.' . $avatar->getClientOriginalExtension();
        $avatar->move($b_path, $file_name);
        if (!empty($user_avatar)) {
            $user_avatar->update([
                'src' => $file_name
            ]);
            return $user_avatar;
        }
        return \App\Models\Users\Avatar::create([
            'user_id' => Auth::id(),
            'src' => $file_name
        ]);
    }

}
