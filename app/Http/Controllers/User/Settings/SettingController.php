<?php

namespace App\Http\Controllers\User\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Settings\SettingRequest;
use App\Http\Requests\User\Settings\TryUpdateEmailUserRequest;
use App\Http\Requests\User\Settings\UpdateAvatarRequest;
use App\Http\Requests\User\Settings\UpdateEmailUserRequest;
use App\Repositories\User\Settings\SettingRepository;
use App\Services\User\Settings\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * @var $service
     * @var $repository
     */
    private $service;
    private $repository;

    public function __construct(SettingService $service, SettingRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function updateBasicData(SettingRequest $request)
    {
        $item = $this->repository->findSpecificDataUser();
        $item = $this->service->updateBasicData($request->all(), $item);
        return response()->json([
            'success' => 1,
            'item' => $item
        ]);
    }

    public function tryUpdateEmailUser(TryUpdateEmailUserRequest $request)
    {
        $tmp = $this->repository->findTmpChangeEmail();
        $this->service->tryUpdateEmailUser($request->all(), $tmp);
        return response()->json([
            'success' => 1
        ]);
    }

    public function updateEmailUser(UpdateEmailUserRequest $request)
    {
        $tmp = $this->repository->findTmpChangeEmail();
        if ($tmp->_key != $request->_key){
            return response()->json([
                'success' => 0
            ]);
        }
        $user = $this->repository->findUser();
        $item = $this->service->updateEmailUser($tmp, $user);
        return response()->json([
            'success' => 1,
            'item' => $item
        ]);
    }

    public function checkTmpEmail()
    {
        return response()->json([
            'is_tmp' => $this->repository->findTmpChangeEmail() ? 1 : 0
        ]);
    }

    public function updateAvatar(UpdateAvatarRequest $request)
    {
        $user_avatar = $this->repository->findAvatarUser();
        $item = $this->service->updateAvatar($request->file('avatar'), $user_avatar);
        return response()->json([
            'success' => 1,
            'item' => $item
        ]);
    }
}
