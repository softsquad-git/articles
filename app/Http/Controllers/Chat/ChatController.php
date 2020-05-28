<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\ChatRequest;
use App\Http\Resources\Chat\ChatResource;
use App\Repositories\Chat\ChatRepository;
use App\Services\Chat\ChatService;
use Illuminate\Http\Request;
use \Exception;
use \Illuminate\Http\JsonResponse;
use \Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ChatController extends Controller
{
    /**
     * @var ChatService
     */
    private $chatService;

    /**
     * @var ChatRepository
     */
    private $chatRepository;

    /**
     * ChatController constructor.
     * @param ChatService $chatService
     * @param ChatRepository $chatRepository
     */
    public function __construct(ChatService $chatService, ChatRepository $chatRepository)
    {
        $this->chatRepository = $chatRepository;
        $this->chatService = $chatService;
    }

    /**
     * @param Request $request
     * @return JsonResponse|AnonymousResourceCollection
     */
    public function getConversations(Request $request)
    {
        $params = [];
        try {
            return ChatResource::collection($this->chatRepository->getConversations($params));
        } catch (Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param ChatRequest $request
     * @return JsonResponse
     */
    public function store(ChatRequest $request)
    {
        try {
            $chat = $this->chatService->store($request->all());
            if (!empty($chat))
                return response()->json(['success' => 1, 'id' => $chat['id']]);
        } catch (Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param ChatRequest $request
     * @param int $chatId
     * @return JsonResponse
     */
    public function update(ChatRequest $request, int $chatId)
    {
        try {
            $data = $request->only(['name', 'status']);
            $this->chatService->update($data, $chatId);
            return response()->json(['success' => 1]);
        } catch (Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    /**
     * @param int $chatId
     * @return JsonResponse
     */
    public function remove(int $chatId)
    {
        try {
            $this->chatService->remove($chatId);
            return response()->json(['success' => 1]);
        } catch (Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    public function find(int $chatId)
    {
        try {
            return new ChatResource($this->chatRepository->findChat($chatId));
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
