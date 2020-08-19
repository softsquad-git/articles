<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Logs;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ActivateRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use \Exception;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
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
        $this->authService->register($userData, $dataSpecificUser);
        return $this->successResponse();
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);
        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized', 'status' => 401], 401);
        }
        Logs::saveAuthLog(Logs::LOGIN);
        return $this->respondWithToken($token);
    }


    /**
     * @param $token
     * @return JsonResponse
     */
    private function respondWithToken($token): JsonResponse
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

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            Auth::guard('api')->logout();
            Logs::saveAuthLog(Logs::LOGOUT);
            return $this->successResponse();
        }catch (Exception $e){
            return $this->catchResponse($e);
        }
    }

    /**
     * @return JsonResponse
     */
    public function refreshToken(): JsonResponse
    {
        try {
            return $this->respondWithToken(Auth::guard('api')->refresh());
        } catch (Exception $e){
            return $this->catchResponse($e);
        }
    }

    /**
     * @param ActivateRequest $request
     * @return JsonResponse
     */
    public function activate(ActivateRequest $request): JsonResponse
    {
        try {
            $this->authService->activate($request->all());
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @return JsonResponse
     */
    public function refreshKeyActivate(): JsonResponse
    {
        try {
            $this->authService->refreshKeyActivate();
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }
}
