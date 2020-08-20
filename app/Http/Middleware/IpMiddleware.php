<?php

namespace App\Http\Middleware;

use Closure;

class IpMiddleware
{
    public $restrictIps = ['103.212.146.23'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (in_array($request->ip(), $this->restrictIps)) {

            return response()->json(["Dzięki :)"]);
        }
        return $next($request);
    }
}
