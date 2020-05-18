<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\ChatMessageRequest;
use App\Http\Resources\Chat\ChatMessageResource;
use App\Repositories\Chat\ChatRepository;
use App\Services\Chat\ChatService;
use Illuminate\Http\Request;
use \Exception;

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

    public function __construct(ChatService $chatService, ChatRepository $chatRepository)
    {
        $this->chatRepository = $chatRepository;
        $this->chatService = $chatService;
    }

    public function getMessages()
    {
        try {
            return ChatMessageResource::collection($this->chatRepository->getMessages());
        } catch (Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    public function sendMessage(ChatMessageRequest $request)
    {
        try {
            $this->chatService->sendMessage($request->all());
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
}
