<?php

namespace App\Http\Controllers\User\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Settings\SettingRequest;
use App\Http\Requests\User\Settings\TryUpdateEmailUserRequest;
use App\Http\Requests\User\Settings\UpdateAvatarRequest;
use App\Http\Requests\User\Settings\UpdateEmailUserRequest;
use App\Repositories\User\Settings\SettingRepository;
use App\Services\User\Settings\SettingService;

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
     * SettingController constructor.
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateBasicData(SettingRequest $request)
    {
        try {
            $this->settingService->updateBasicData($request->all());
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param TryUpdateEmailUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tryUpdateEmailUser(TryUpdateEmailUserRequest $request)
    {
        try {
            $this->settingService->tryUpdateEmailUser($request->all());
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param UpdateEmailUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEmailUser(UpdateEmailUserRequest $request)
    {
        try {
            $this->settingService->updateEmailUser($request->_key);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkTmpEmail()
    {
        try {
            return response()->json(['is_tmp' => $this->settingRepository->findTmpChangeEmail() ? 1 : 0]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param UpdateAvatarRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAvatar(UpdateAvatarRequest $request)
    {
        try {
            $this->settingService->updateAvatar($request->file('avatar'));
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param bool $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function setTemplateMode(bool $type)
    {
        try{
            $mode = $this->settingService->setTemplateMode($type);
            return response()->json(['success' => 1, 'mode' => $mode]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    public function removeAccount()
    {
        try {
            $this->settingService->removeAccount();
            return response()->json(['success' => 1]);
        } catch (\Exception $e)
        {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
