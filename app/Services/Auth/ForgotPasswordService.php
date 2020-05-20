<?php

namespace App\Services\Auth;

use App\Helpers\Logs;
use App\Helpers\VerifyEmail;
use App\Mail\User\ForgotPasswordMail;
use App\Models\Users\ForgotPassword;
use App\Repositories\Auth\ForgotPasswordRepository;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordService
{
    /**
     * @var ForgotPasswordRepository
     */
    private $forgotPasswordRepository;

    public function __construct(ForgotPasswordRepository $forgotPasswordRepository)
    {
        $this->forgotPasswordRepository = $forgotPasswordRepository;
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    public function sendVerifyKey(array $data)
    {
        $email = $data['email'];
        $account = $this->forgotPasswordRepository->checkEmptyAccount($email);
        $forgot = ForgotPassword::create([
            'email' => $email,
            '_key' => VerifyEmail::generateKey()
        ]);
        $data = [
            'account' => $account,
            'key' => $forgot->_key
        ];
        Mail::to($email)->send(new ForgotPasswordMail($data));
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function newPassword(array $data)
    {
        $key = $this->forgotPasswordRepository->getKey($data['email']);
        if ($key->_key != $data['key'])
            throw new \Exception('Podany kod jest nieprawidłowy');
        $data['password'] = Hash::make($data['password']);
        $user = User::where('email', $key->email)->first();
        $user->update($data);
        $key->delete();
        Logs::saveAuthLog(Logs::REMIND_PASSWORD);
        return $user;
    }
}
