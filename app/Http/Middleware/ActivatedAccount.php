<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Http\JsonResponse;

class ActivatedAccount
{
    /**
     * @param $request
     * @param Closure $next
     * @return JsonResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->activated != 1) {
            return response()->json([
                'msg' => 'Account is not activated!',
                'status_code' => config('app.enum.status_code_no_activate')
            ], 403);
        }
        return $next($request);
    }
}
