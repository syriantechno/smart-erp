<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ChatController extends Controller
{
    public function index()
    {
        $conversations = Conversation::forUser(auth()->id())
                                   ->active()
                                   ->with(['participants:id,name', 'latestMessage.sender:id,name'])
                                   ->orderByDesc('updated_at')
                                   ->get();

        $users = User::where('id', '!=', auth()->id())
                    ->select('id', 'name')
                    ->get();

        $unreadCount = $this->getTotalUnreadCount();

        return view('chat.index', compact('conversations', 'users', 'unreadCount'));
    }

    public function getConversations(): JsonResponse
    {
        $conversations = Conversation::forUser(auth()->id())
                                   ->active()
                                   ->with(['participants:id,name,email', 'latestMessage'])
                                   ->orderByDesc('updated_at')
                                   ->get()
                                   ->map(function ($conversation) {
                                       return [
                                           'id' => $conversation->id,
                                           'display_name' => $conversation->display_name,
                                           'type' => $conversation->type,
                                           'unread_count' => $conversation->unread_count,
                                           'last_message' => $conversation->latestMessage ? [
                                               'content' => $conversation->latestMessage->content,
                                               'created_at' => $conversation->latestMessage->formatted_time,
                                               'sender_name' => $conversation->latestMessage->sender->name,
                                           ] : null,
                                           'participants' => $conversation->participants->map(function ($user) {
                                               return [
                                                   'id' => $user->id,
                                                   'name' => $user->name,
                                                   'email' => $user->email,
                                               ];
                                           }),
                                       ];
                                   });

        return response()->json([
            'success' => true,
            'conversations' => $conversations,
        ]);
    }

    public function getMessages($conversationId): JsonResponse
    {
        $conversation = Conversation::findOrFail($conversationId);

        // Check if user is participant
        if (!$conversation->participants()->where('user_id', auth()->id())->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied',
            ], 403);
        }

        // Mark conversation as read
        $conversation->markAsRead(auth()->id());

        $messages = $conversation->messages()
                                ->with('sender:id,name')
                                ->orderBy('created_at', 'asc')
                                ->get()
                                ->map(function ($message) {
                                    return [
                                        'id' => $message->id,
                                        'content' => $message->content,
                                        'message_type' => $message->message_type,
                                        'is_own' => $message->is_own,
                                        'sender' => [
                                            'id' => $message->sender->id,
                                            'name' => $message->sender->name,
                                        ],
                                        'formatted_time' => $message->formatted_time,
                                        'formatted_date' => $message->formatted_date,
                                        'metadata' => $message->metadata,
                                        'file_url' => $message->file_url,
                                        'file_name' => $message->file_name,
                                        'file_size' => $message->file_size,
                                    ];
                                });

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'conversation' => [
                'id' => $conversation->id,
                'display_name' => $conversation->display_name,
                'type' => $conversation->type,
            ],
        ]);
    }

    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'content' => 'required_without:file|string',
            'file' => 'nullable|file|max:10240', // 10MB max
        ]);

        $conversation = Conversation::findOrFail($request->conversation_id);

        // Check if user is participant
        if (!$conversation->participants()->where('user_id', auth()->id())->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied',
            ], 403);
        }

        try {
            DB::beginTransaction();

            $messageData = [
                'conversation_id' => $conversation->id,
                'sender_id' => auth()->id(),
                'message_type' => 'text',
            ];

            // Handle file upload
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $path = $file->store('chat-files', 'public');

                $messageData['content'] = $file->getClientOriginalName();
                $messageData['message_type'] = $this->getFileType($file);
                $messageData['metadata'] = [
                    'original_name' => $file->getClientOriginalName(),
                    'path' => basename($path),
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ];
            } else {
                $messageData['content'] = $request->content;
            }

            $message = Message::create($messageData);

            // Update conversation timestamp
            $conversation->touch();

            DB::commit();

            // Broadcast the message
            broadcast(new MessageSent($message))->toOthers();

            return response()->json([
                'success' => true,
                'message' => $message->load('sender:id,name'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function startConversation(Request $request): JsonResponse
    {
        $request->validate([
            'participant_id' => 'required|exists:users,id|different:' . auth()->id(),
            'type' => 'required|in:direct,group',
            'title' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Check if direct conversation already exists
            if ($request->type === 'direct') {
                $existingConversation = Conversation::where('type', 'direct')
                    ->whereHas('participants', function ($q) {
                        $q->where('user_id', auth()->id());
                    })
                    ->whereHas('participants', function ($q) use ($request) {
                        $q->where('user_id', $request->participant_id);
                    })
                    ->first();

                if ($existingConversation) {
                    DB::rollBack();
                    return response()->json([
                        'success' => true,
                        'conversation_id' => $existingConversation->id,
                        'message' => 'Conversation already exists',
                    ]);
                }
            }

            // Create new conversation
            $conversation = Conversation::create([
                'type' => $request->type,
                'title' => $request->title,
                'created_by' => auth()->id(),
            ]);

            // Add participants
            $conversation->addParticipant(auth()->id(), true);

            if ($request->type === 'direct') {
                $conversation->addParticipant($request->participant_id);
            } elseif ($request->type === 'group' && $request->has('participant_ids')) {
                foreach ($request->participant_ids as $participantId) {
                    $conversation->addParticipant($participantId);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'conversation_id' => $conversation->id,
                'message' => 'Conversation created successfully',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create conversation: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function markAsRead($conversationId): JsonResponse
    {
        $conversation = Conversation::findOrFail($conversationId);

        if (!$conversation->participants()->where('user_id', auth()->id())->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Access denied',
            ], 403);
        }

        $conversation->markAsRead(auth()->id());

        return response()->json([
            'success' => true,
            'message' => 'Conversation marked as read',
        ]);
    }

    public function getUnreadCount(): JsonResponse
    {
        $unreadCount = $this->getTotalUnreadCount();

        return response()->json([
            'success' => true,
            'unread_count' => $unreadCount,
        ]);
    }

    private function getTotalUnreadCount(): int
    {
        return Conversation::forUser(auth()->id())
                          ->active()
                          ->get()
                          ->sum(function ($conversation) {
                              return $conversation->unread_count;
                          });
    }

    private function getFileType($file): string
    {
        $mime = $file->getMimeType();

        if (str_starts_with($mime, 'image/')) {
            return 'image';
        }

        return 'file';
    }
}
