<?php

namespace App\Services\User\Settings;

use App\Helpers\Avatar;
use App\Helpers\Logs;
use App\Helpers\UpdateStatusUser;
use App\Helpers\Upload;
use App\Helpers\VerifyEmail;
use App\Mail\User\VerifyNewEmailUserMail;
use App\Models\Users\ChangeEmail;
use App\Repositories\User\Settings\SettingRepository;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use \Exception;

class SettingService
{

    /**
     * @var SettingRepository
     */
    private $settingRepository;

    /**
     * @param SettingRepository $settingRepository
     */
    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function updateBasicData(array $data)
    {
        $item = $this->settingRepository->findSpecificDataUser();
        $item->update($data);
        return $item;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function tryUpdateEmailUser(array $data)
    {
        $item = $this->settingRepository->findTmpChangeEmail();
        $data['_key'] = VerifyEmail::generateKey();
        if (empty($item)) {
            $data['user_id'] = Auth::id();
            $item = ChangeEmail::create($data);
            return Mail::to(Auth::user()->email)->send(new VerifyNewEmailUserMail($item));
        }
        $item->update($data);
        return Mail::to(Auth::user()->email)->send(new VerifyNewEmailUserMail($item));
    }

    /**
     * @param string $key
     * @return User
     * @throws Exception
     */
    public function updateEmailUser(string $key): User
    {
        $tmp_item = $this->settingRepository->findTmpChangeEmail();
        if ($tmp_item->_key != $key)
            throw new \Exception(sprintf('Code provided is invalid'));
        $item = $this->settingRepository->findUser();
        Logs::saveAuthLog(Logs::CHANGE_EMAIL);
        $item->update(['email' => $tmp_item->tmp_email]);
        UpdateStatusUser::setActivateUser(0);
        $tmp_item->delete();
        return $item;
    }

    /**
     * @param $avatar
     * @return mixed
     * @throws Exception
     */
    public function updateAvatar($avatar)
    {
        $user_avatar = $this->settingRepository->findAvatarUser();
        $fileName = Upload::singleFile(Avatar::PATH, $avatar);
        if (!empty($user_avatar)) {
            $user_avatar->update([
                'src' => $fileName
            ]);
            return $user_avatar;
        }
        return \App\Models\Users\Avatar::create([
            'user_id' => Auth::id(),
            'src' => $fileName
        ]);
    }

    /**
     * @param bool $type
     * @return mixed
     */
    public function setTemplateMode(bool $type)
    {
        $user = $this->settingRepository->findUser();
        $user->update([
            'dark_mode' => $type
        ]);
        return $user->dark_mode;
    }

    public function removeAccount()
    {
        return User::find(Auth::id())->delete();
    }

    /**
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function updatePassword(array $data)
    {
        $user = $this->settingRepository->findUser();
        if (Hash::check($data['old_password'], $user->password)) {
            $user->update([
                'password' => Hash::make($data['new_password'])
            ]);
            Logs::saveAuthLog(Logs::CHANGE_PASSWORD);
            return $user;
        }
        throw new Exception('Podałeś nieprawidłowe hasło');
    }

}
