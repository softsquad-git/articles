<?php

namespace App\Helpers;

use App\Models\Users\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Logs
{
    const LOGOUT = 'LOGOUT';
    const LOGIN = 'LOGIN';
    const REGISTER = 'REGISTER';
    const CHANGE_PASSWORD = 'CHANGE_PASSWORD';
    const REMIND_PASSWORD = 'REMIND_PASSWORD';
    const CHANGE_EMAIL = 'CHANGE_EMAIL';

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
