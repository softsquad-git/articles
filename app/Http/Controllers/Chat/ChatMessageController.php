<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\ChatMessageRequest;
use App\Http\Resources\Chat\ChatMessageResource;
use App\Repositories\Chat\ChatMessagesRepository;
use App\Services\Chat\ChatMessageService;
use Illuminate\Http\Request;

class ChatMessageController extends Controller
{
    /**
     * @var ChatMessagesRepository
     */
    private $chatMessagesRepository;

    /**
     * @var ChatMessageService
     */
    private $chatMessagesService;

    public function __construct(ChatMessageService $chatMessageService, ChatMessagesRepository $chatMessagesRepository)
    {
        $this->chatMessagesRepository = $chatMessagesRepository;
        $this->chatMessagesService = $chatMessageService;
    }

    public function getMessages(Request $request)
    {
        $params = [
            'chat_id' => $request->input('chat_id')
        ];
        try {
            return ChatMessageResource::collection($this->chatMessagesRepository->getMessages($params));
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    public function store(ChatMessageRequest $request)
    {
        try {
            $this->chatMessagesService->store($request->all());
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    public function update(ChatMessageRequest $request, int $messageId)
    {
        try {
            $this->chatMessagesService->update($request->all(), $messageId);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }

    public function remove(int $messageId)
    {
        try {
            $this->chatMessagesService->remove($messageId);
            return response()->json(['success' => 1]);
        } catch (\Exception $e) {
            return response()->json(['success' => 0, 'msg' => $e->getMessage()]);
        }
    }
}
