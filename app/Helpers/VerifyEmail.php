<?php


namespace App\Helpers;


use App\Mail\User\VerifyEmailMail;
use App\Models\Users\VerificationEmail;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VerifyEmail
{

    private static function generateKey()
    {
        return substr(md5(time() . date('Y-m-d H:i:s')), 15, 15);
    }

    public static function verify($user_id)
    {
        $key = self::generateKey();
        $keyDB = self::getKey();
        $user = self::getUser($user_id);
        $data = [
            'user_id' => $user_id,
            'key' => $key,
            'user' => $user
        ];
        if (!empty($keyDB)) {
            self::removeKey($keyDB->id);
            self::saveKeyInToDb($key, $user_id);

            return self::sendEmailVerify($data);
        }

        self::saveKeyInToDb($key, $user_id);

        return self::sendEmailVerify($data);
    }

    private static function getKey()
    {
        return VerificationEmail::where('user_id', Auth::id())->first();
    }

    private static function removeKey($id)
    {
        $key = VerificationEmail::find($id);
        $key->delete();

        return true;
    }

    private static function saveKeyInToDb($key, $user_id)
    {
        $item = VerificationEmail::create([
            'user_id' => $user_id,
            '_key' => $key
        ]);

        return $item;
    }

    private static function sendEmailVerify($data)
    {
        return Mail::to($data['user']->email)
            ->send(new VerifyEmailMail($data));
    }

    private static function getUser($user_id)
    {
        return User::find($user_id);
    }

}
