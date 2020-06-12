<?php

namespace App\Http\Controllers\Users\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Settings\SettingRequest;
use App\Http\Requests\User\Settings\TryUpdateEmailUserRequest;
use App\Http\Requests\User\Settings\UpdateAvatarRequest;
use App\Http\Requests\User\Settings\UpdateEmailUserRequest;
use App\Http\Requests\User\Settings\UpdatePasswordUserRequest;
use App\Repositories\User\Settings\SettingRepository;
use App\Services\User\Settings\SettingService;
use \Illuminate\Http\JsonResponse;
use \Exception;

class SettingController extends Controller
{
    /**
     * @var SettingService
     */
    private $settingService;
    /**
     * @var SettingRepository
     */
    private $settingRepository;

    /**
     * @param SettingService $settingService
     * @param SettingRepository $settingRepository
     */
    public function __construct(SettingService $settingService, SettingRepository $settingRepository)
    {
        $this->settingService = $settingService;
        $this->settingRepository = $settingRepository;
    }

    /**
     * @param SettingRequest $request
     * @return JsonResponse
     */
    public function updateBasicData(SettingRequest $request)
    {
        try {
            $this->settingService->updateBasicData($request->all());
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param TryUpdateEmailUserRequest $request
     * @return JsonResponse
     */
    public function tryUpdateEmailUser(TryUpdateEmailUserRequest $request)
    {
        try {
            $this->settingService->tryUpdateEmailUser($request->all());
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param UpdateEmailUserRequest $request
     * @return JsonResponse
     */
    public function updateEmailUser(UpdateEmailUserRequest $request)
    {
        try {
            $this->settingService->updateEmailUser($request->_key);
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @return JsonResponse
     */
    public function checkTmpEmail()
    {
        try {
            return response()->json(['is_tmp' => $this->settingRepository->findTmpChangeEmail() ? 1 : 0]);
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param UpdateAvatarRequest $request
     * @return JsonResponse
     */
    public function updateAvatar(UpdateAvatarRequest $request)
    {
        try {
            $this->settingService->updateAvatar($request->file('avatar'));
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param bool $type
     * @return JsonResponse
     */
    public function setTemplateMode(bool $type)
    {
        try {
            $mode = $this->settingService->setTemplateMode($type);
            return response()->json(['success' => 1, 'mode' => $mode]);
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @return JsonResponse
     */
    public function removeAccount()
    {
        try {
            $this->settingService->removeAccount();
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

    /**
     * @param UpdatePasswordUserRequest $request
     * @return JsonResponse
     */
    public function updatePassword(UpdatePasswordUserRequest $request)
    {
        try {
            $this->settingService->updatePassword($request->all());
            return $this->successResponse();
        } catch (Exception $e) {
            return $this->catchResponse($e);
        }
    }

}
