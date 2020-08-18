<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\SendVerifyKeyForgotPasswordRequest;
use App\Repositories\Auth\ForgotPasswordRepository;
use App\Services\Auth\ForgotPasswordService;
use Illuminate\Http\Request;

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

    public function __construct(
        ForgotPasswordService $forgotPasswordService,
        ForgotPasswordRepository $forgotPasswordRepository
    )
    {
        $this->forgotPasswordRepository = $forgotPasswordRepository;
        $this->forgotPasswordService = $forgotPasswordService;
    }

    public function sendKeyVerify(SendVerifyKeyForgotPasswordRequest $request)
    {
        try {
            $this->forgotPasswordService->sendVerifyKey($request->all());
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    public function newPassword(ForgotPasswordRequest $request)
    {
        try {
            $this->forgotPasswordService->newPassword($request->all());
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
