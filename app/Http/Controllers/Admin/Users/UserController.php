<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserResource;
use App\Repositories\ADMIN\Users\UserRepository;
use App\Services\ADMIN\Users\UserService;
use Illuminate\Http\Request;
use \Exception;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $_A_UserRepository;

    /**
     * @var UserService
     */
    private $_A_UserService;

    public function __construct(UserRepository $userRepository, UserService $_A_UserService)
    {
        $this->_A_UserRepository = $userRepository;
        $this->_A_UserService = $_A_UserService;
    }

    public function getUsers(Request $request)
    {
        $params = [
            'name' => $request->input('name'),
            'activated' => $request->input('activated'),
            'locked' => $request->input('locked'),
            'sex' => $request->input('sex')
        ];
        try {
            return UserResource::collection($this->_A_UserRepository->getUsers($params));
        } catch (Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    public function changeActivated(int $value, int $userId)
    {
        try {
            $this->_A_UserService->changeActivated($value, $userId);
            return response()->json([
                'success' => 1
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => 0,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function changeLocked(int $value, int $userId)
    {
        try {
            $this->_A_UserService->changeLocked($value, $userId);
            return response()->json([
                'success' => 1
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => 0,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function findUser(int $userId)
    {
        try {
            return new UserResource($this->_A_UserRepository->findUser($userId));
        } catch (Exception $e) {
            return response()->json([
                'success' => 0
            ]);
        }
    }
}
