<?php

namespace App\Http\Controllers;

use App\Models\SupportThread;
use App\Services\SupportChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StorefrontGuestChatController extends Controller
{
    public function __construct(
        protected SupportChatService $chat,
    ) {}

    public function start(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $token = Str::random(48);
        $thread = $this->chat->createGuestThread(
            $validated['name'],
            $validated['email'],
            $token
        );

        $request->session()->put('storefront_chat_token', $token);

        return response()->json([
            'token' => $token,
            'thread_id' => $thread->id,
            'message' => 'Chat started. How can we help you today?',
        ], 201);
    }

    public function messages(Request $request): JsonResponse
    {
        $thread = $this->resolveGuestThread($request);
        if (! $thread) {
            return response()->json(['data' => []]);
        }

        $messages = $thread->messages()
            ->orderBy('id')
            ->get()
            ->map(fn ($msg) => $this->serializeGuestMessage($msg, $thread));

        return response()->json([
            'data' => $messages,
            'thread' => $this->serializeGuestThread($thread),
            'server_time' => now()->toIso8601String(),
        ]);
    }

    public function send(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:5000',
            'token' => 'nullable|string|size:48',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $thread = $this->resolveGuestThread($request, $validated['token'] ?? null);

        if (! $thread && ! empty($validated['name']) && ! empty($validated['email'])) {
            $token = Str::random(48);
            $thread = $this->chat->createGuestThread($validated['name'], $validated['email'], $token);
            $request->session()->put('storefront_chat_token', $token);
        }

        if (! $thread) {
            return response()->json(['message' => 'Start chat with your name and email first.'], 422);
        }

        $record = $this->chat->sendGuestMessage($thread, $thread->guest_name, $validated['message']);

        return response()->json([
            'message' => 'Sent.',
            'data' => $this->serializeGuestMessage($record, $thread),
            'token' => $thread->guest_token,
        ]);
    }

    protected function resolveGuestThread(Request $request, ?string $token = null): ?SupportThread
    {
        $token = $token ?: $request->header('X-Storefront-Chat-Token') ?: $request->input('token') ?: $request->session()->get('storefront_chat_token');

        if (! is_string($token) || strlen($token) < 32) {
            return null;
        }

        return SupportThread::query()
            ->where('guest_token', $token)
            ->where('is_storefront_guest', true)
            ->first();
    }

    protected function serializeGuestThread(SupportThread $thread): array
    {
        return [
            'id' => $thread->id,
            'guest_name' => $thread->guest_name,
            'guest_email' => $thread->guest_email,
            'title' => 'Storefront chat',
        ];
    }

    protected function serializeGuestMessage($message, SupportThread $thread): array
    {
        $isGuest = $message->user_id === null;

        return [
            'id' => $message->id,
            'message' => $message->message,
            'is_mine' => $isGuest,
            'is_admin' => ! $isGuest,
            'user_name' => $isGuest ? ($message->guest_name ?: $thread->guest_name) : ($message->user?->name ?? 'Admin'),
            'created_at' => $message->created_at?->format('M j, Y g:i A'),
        ];
    }
}
