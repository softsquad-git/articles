<?php

namespace App\Http\Controllers\Users\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Groups\GroupRequest;
use App\Http\Resources\User\Friends\Groups\GroupResource;
use App\Http\Resources\Users\Groups\PostsImagesGroupResource;
use App\Repositories\User\Groups\GroupsRepository;
use App\Services\User\Groups\GroupsService;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GroupController extends Controller
{
    /**
     * @var GroupsRepository
     */
    private $groupsRepository;

    /**
     * @var GroupsService
     */
    private $groupsService;

    /**
     * GroupController constructor.
     * @param GroupsService $groupsService
     * @param GroupsRepository $groupsRepository
     */
    public function __construct(
        GroupsService $groupsService,
        GroupsRepository $groupsRepository
    )
    {
        $this->groupsRepository = $groupsRepository;
        $this->groupsService = $groupsService;
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function getGroups(Request $request)
    {
        $params = [
            'ordering' => $request->input('ordering')
        ];
        return GroupResource::collection($this->groupsRepository->getGroups($params));
    }

    /**
     * @param int $id
     * @return GroupResource|JsonResponse
     */
    public function preview(int $id)
    {
        try {
            $group = $this->groupsRepository->findGroup($id);
            if (empty($group))
                throw new \Exception(sprintf('Group %d not found', $id));
            return new GroupResource($group);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param GroupRequest $request
     * @return JsonResponse
     */
    public function store(GroupRequest $request)
    {
        try {
            if ($request->hasFile('bg_image'))
                $file = $request->file('bg_image');
            else
                $file = '';
            $this->groupsService->store($request->all(), $file);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param GroupRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(GroupRequest $request, int $id)
    {
        try {
            if ($request->hasFile('bg_image'))
                $file = $request->file('bg_image');
            else
                $file = '';
            $this->groupsService->update($request->all(), $id, $file);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function remove(int $id)
    {
        try {
            $this->groupsService->remove($id);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getAllImages(int $id)
    {
        try {
            $images = $this->groupsRepository->getAllImages($id);
            return response()->json([
                'data' => $images
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
