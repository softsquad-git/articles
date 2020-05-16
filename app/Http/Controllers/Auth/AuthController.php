<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ActivateRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @var $service
     */
    private $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function register(RegisterRequest $request)
    {
        $userData = $request->only([
            'email',
            'password'
        ]);
        $dataSpecificUser = $request->only([
            'name',
            'last_name',
            'birthday',
            'number_phone',
            'city',
            'post_code',
            'address',
            'sex',
            'terms'
        ]);
        $item = $this->service->register($userData, $dataSpecificUser);

        return response()->json([
            'item' => $item,
            'success' => 1
        ]);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized', 'status' => 401], 401);
        }
        return $this->respondWithToken($token);
    }

    private function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user_id' => Auth::id(),
            'success' => 1,
            'dark_mode' => Auth::user()->dark_mode == 1 ? true : false
        ]);
    }

    public function logout()
    {
        try {
            Auth::guard('api')->logout();
            return response()->json([
                'success' => 1,
                'msg' => 'Logout'
            ]);
        }catch (\Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function refreshToken()
    {
        try {
            return $this->respondWithToken(Auth::guard('api')->refresh());
        } catch (\Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function activate(ActivateRequest $request)
    {
        try {
            $this->service->activate($request->all());
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    public function refreshKeyActivate()
    {
        try {
            $this->service->refreshKeyActivate();
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
