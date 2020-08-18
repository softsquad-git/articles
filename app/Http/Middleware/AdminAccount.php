<?php

namespace App\Http\Middleware;

use App\Helpers\Status;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->r_role != Status::R_ADMIN) {
            return response()->json([
                'success' => 0,
                'msg' => 'Nie masz dostępu do tej strony'
            ], 403);
        }
        return $next($request);
    }
}
