<?php

namespace App\Services\User\Settings;

use App\Helpers\Avatar;
use App\Helpers\UpdateStatusUser;
use App\Helpers\VerifyEmail;
use App\Mail\User\SuccessUpdateEmailMail;
use App\Mail\User\VerifyNewEmailUserMail;
use App\Models\Users\ChangeEmail;
use App\Repositories\User\Settings\SettingRepository;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SettingService
{

    /**
     * @var SettingRepository
     */
    private $settingRepository;

    /**
     * SettingService constructor.
     * @param SettingRepository $settingRepository
     */
    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function updateBasicData(array $data)
    {
        $item = $this->settingRepository->findSpecificDataUser();
        if (empty($item))
            throw new \Exception(sprintf('Try again'));
        $item->update($data);
        return $item;
    }

    /**
     * @param array $data
     * @return mixed
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
     * @throws \Exception
     */
    public function updateEmailUser(string $key): User
    {
        $tmp_item = $this->settingRepository->findTmpChangeEmail();
        if (empty($tmp_item))
            throw new \Exception(sprintf('An error occured. Start the procedure of changing the email address again'));
        if ($tmp_item->_key != $key)
            throw new \Exception(sprintf('Code provided is invalid'));
        $item = $this->settingRepository->findUser();
        if (empty($item))
            throw new \Exception(sprintf('User not found'));
        $item->update(['email' => $tmp_item->tmp_email]);
        UpdateStatusUser::setActivateUser(0);
        $tmp_item->delete();
        return $item;
    }

    /**
     * @param $avatar
     * @return mixed
     */
    public function updateAvatar($avatar)
    {
        $user_avatar = $this->settingRepository->findAvatarUser();
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
     * @throws \Exception
     */
    public function updatePassword(array $data)
    {
        $user = $this->settingRepository->findUser();
        if (Hash::check($data['old_password'], $user->password)) {
            $user->update([
                'password' => Hash::make($data['new_password'])
            ]);
            return $user;
        }
        throw new \Exception('Podałeś nieprawidłowe hasło');
    }

}
