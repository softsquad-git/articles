<?php

namespace App\Helpers;

use App\Mail\User\VerifyEmailMail;
use App\Models\Users\VerificationEmail;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use \Exception;

class VerifyEmail
{

    /**
     * @return string
     */
    public static function generateKey(): string
    {
        return substr(md5(time() . date('Y-m-d H:i:s')), 15, 15);
    }

    /**
     * @param int $userId
     * @param string $key
     * @return array
     */
    private static function prepareData(int $userId, string $key): array
    {
        return [
            'user_id' => $userId,
            'key' => $key,
            'user' => self::getUser($userId)
        ];
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public static function verify(int $userId)
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
     * @param int $id
     * @return bool
     */
    private static function removeKey(int $id)
    {
        $key = VerificationEmail::find($id);
        $key->delete();

        return true;
    }

    /**
     * @param string $key
     * @param int $user_id
     * @return mixed
     */
    private static function saveKeyInToDb(string $key, int $user_id)
    {
        return VerificationEmail::create([
            'user_id' => $user_id,
            '_key' => $key
        ]);
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
     * @throws Exception
     */
    public static function updateKey()
    {
        $key = self::getKey();
        $newKey = self::generateKey();
        if (!empty($key)) {
            VerificationEmail::where('id', $key->id)
                ->update([
                    '_key' => $newKey
                ]);
        } else {
            self::saveKeyInToDb($newKey, Auth::id());
        }
        return self::sendEmailVerify(self::prepareData(Auth::id(), $newKey));
    }

}
