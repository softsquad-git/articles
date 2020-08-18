<?php

namespace App\Helpers;

use App\Models\Users\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Logs
{
    public const LOGOUT = 'LOGOUT';
    public const LOGIN = 'LOGIN';
    public const REGISTER = 'REGISTER';
    public const CHANGE_PASSWORD = 'CHANGE_PASSWORD';
    public const REMIND_PASSWORD = 'REMIND_PASSWORD';
    public const CHANGE_EMAIL = 'CHANGE_EMAIL';

    /**
     * @param string $action
     */
    public static function saveAuthLog(string $action)
    {
        try {
            $request = app(Request::class);
            UserLog::create([
                'user_id' => Auth::id() ?? 0,
                'action' => $action,
                'ip_address' => $request->getClientIp()
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
