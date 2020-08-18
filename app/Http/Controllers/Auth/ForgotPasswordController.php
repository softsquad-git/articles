<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\SendVerifyKeyForgotPasswordRequest;
use App\Repositories\Auth\ForgotPasswordRepository;
use App\Services\Auth\ForgotPasswordService;
use Illuminate\Http\JsonResponse;
use \Exception;

class ForgotPasswordController extends Controller
{
    /**
     * @var ForgotPasswordRepository
     */
    private $forgotPasswordRepository;

    /**
     * @var ForgotPasswordService
     */
    private $forgotPasswordService;

    /**
     * @param ForgotPasswordService $forgotPasswordService
     * @param ForgotPasswordRepository $forgotPasswordRepository
     */
    public function __construct(
        ForgotPasswordService $forgotPasswordService,
        ForgotPasswordRepository $forgotPasswordRepository
    )
    {
        $this->forgotPasswordRepository = $forgotPasswordRepository;
        $this->forgotPasswordService = $forgotPasswordService;
    }

    public function sendKeyVerify(SendVerifyKeyForgotPasswordRequest $request): JsonResponse
    {
        try {
            $this->forgotPasswordService->sendVerifyKey($request->all());
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function newPassword(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $this->forgotPasswordService->newPassword($request->all());
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }
}
