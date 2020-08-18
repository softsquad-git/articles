<?php

namespace App\Helpers;

use App\Mail\User\VerifyEmailMail;
use App\Models\Users\VerificationEmail;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VerifyEmail
{

    public static function generateKey()
    {
        return substr(md5(time() . date('Y-m-d H:i:s')), 15, 15);
    }

    private static function prepareData(int $userId, string $key): array
    {
        return [
            'user_id' => $userId,
            'key' => $key,
            'user' => self::getUser($userId)
        ];
    }

    /**
     * @param $userId
     * @return mixed
     */
    public static function verify($userId)
    {
        $key = self::generateKey();
        $keyDB = self::getKey();
        $data = self::prepareData($userId, $key);
        if (!empty($keyDB)) {
            self::removeKey($keyDB->id);
            self::saveKeyInToDb($key, $userId);

            return self::sendEmailVerify($data);
        }

        self::saveKeyInToDb($key, $userId);

        return self::sendEmailVerify($data);
    }

    /**
     * @return mixed
     */
    private static function getKey()
    {
        return VerificationEmail::where('user_id', Auth::id())->first();
    }

    /**
     * @param $id
     * @return bool
     */
    private static function removeKey($id)
    {
        $key = VerificationEmail::find($id);
        $key->delete();

        return true;
    }

    /**
     * @param $key
     * @param $user_id
     * @return mixed
     */
    private static function saveKeyInToDb($key, $user_id)
    {
        $item = VerificationEmail::create([
            'user_id' => $user_id,
            '_key' => $key
        ]);

        return $item;
    }

    /**
     * @param $data
     * @return mixed
     */
    private static function sendEmailVerify($data)
    {
        return Mail::to($data['user']->email)
            ->send(new VerifyEmailMail($data));
    }

    /**
     * @param $user_id
     * @return mixed
     */
    private static function getUser($user_id)
    {
        return User::find($user_id);
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function checkKeys(string $key): bool
    {
        $keyDb = self::getKey();
        if ($keyDb->_key != $key)
            return false;
        self::removeKey($keyDb->id);
        return true;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public static function updateKey()
    {
        $key = self::getKey();
        if (empty($key))
            throw new \Exception('ERROR');
        $newKey = self::generateKey();
        VerificationEmail::where('id', $key->id)
            ->update([
                '_key' => $newKey
            ]);
        return self::sendEmailVerify(self::prepareData(Auth::id(), $newKey));
    }

}
