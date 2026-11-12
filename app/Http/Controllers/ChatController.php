<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Verify that a guest token is authentic (HMAC-signed by this app).
     * Tokens are issued by issueGuestToken() and stored client-side together
     * with their signature; forgeable random strings are rejected.
     */
    private function verifyGuestToken(string $token, ?string $signature): bool
    {
        return is_string($signature)
            && $signature !== ''
            && hash_equals($this->guestTokenSignature($token), $signature);
    }

    private function guestTokenSignature(string $token): string
    {
        return hash_hmac('sha256', $token, config('app.key'));
    }

    /**
     * Issue a fresh signed guest identity to the browser.
     */
    public function issueGuestToken()
    {
        $token = 'guest_' . bin2hex(random_bytes(16));

        return response()->json([
            'success' => true,
            'guest_token' => $token,
            'signature' => $this->guestTokenSignature($token),
        ]);
    }

    // Guest fetch messages for a specific DKM
    public function getMessages(Request $request)
    {
        $guestToken = $request->query('guest_token');
        $dkmId = $request->query('dkm_id');

        if (!$guestToken || !$dkmId) {
            return response()->json(['messages' => []]);
        }

        if (!$this->verifyGuestToken($guestToken, $request->query('signature'))) {
            return response()->json(['success' => false, 'messages' => []], 403);
        }

        if (!$this->approvedDkmExists($dkmId)) {
            return response()->json(['success' => false, 'messages' => []], 404);
        }

        $messages = ChatMessage::where('guest_token', $guestToken)
            ->where('dkm_id', $dkmId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

    // Guest send message to DKM
    public function sendMessage(Request $request)
    {
        $request->validate([
            'guest_token' => 'required|string',
            'guest_name' => 'nullable|string',
            'dkm_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        if (!$this->verifyGuestToken($request->guest_token, $request->input('signature'))) {
            return response()->json(['success' => false, 'message' => 'Invalid guest token.'], 403);
        }

        if (!$this->approvedDkmExists($request->dkm_id)) {
            return response()->json(['success' => false, 'message' => 'DKM tidak ditemukan atau belum disetujui.'], 404);
        }

        $msg = ChatMessage::create([
            'guest_token' => $request->guest_token,
            'guest_name' => $request->guest_name ?: 'Tamu Penanya',
            'dkm_id' => $request->dkm_id,
            'sender_type' => 'guest',
            'message' => $request->message,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => $msg
        ]);
    }

    /**
     * Ensure the target dkm_id belongs to an approved DKM admin.
     */
    private function approvedDkmExists($dkmId): bool
    {
        return User::where('id', $dkmId)
            ->where('role', 'dkm_admin')
            ->where('is_approved', true)
            ->exists();
    }

    // DKM view active guest conversations
    public function getDkmConversations()
    {
        $dkm = Auth::user();

        // Group messages by guest_token (single query, no N+1)
        $conversations = ChatMessage::conversationsForDkm($dkm->id);

        return response()->json([
            'success' => true,
            'conversations' => $conversations
        ]);
    }

    // DKM fetch messages for a specific guest_token
    public function getDkmGuestMessages(Request $request, $guestToken)
    {
        $dkm = Auth::user();

        // Mark as read
        ChatMessage::where('dkm_id', $dkm->id)
            ->where('guest_token', $guestToken)
            ->where('sender_type', 'guest')
            ->update(['is_read' => true]);

        $messages = ChatMessage::where('dkm_id', $dkm->id)
            ->where('guest_token', $guestToken)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }

    // DKM send reply to guest
    public function sendDkmReply(Request $request)
    {
        $request->validate([
            'guest_token' => 'required|string',
            'message' => 'required|string|max:1000',
        ]);

        $dkm = Auth::user();

        $msg = ChatMessage::create([
            'guest_token' => $request->guest_token,
            'guest_name' => 'DKM Admin',
            'dkm_id' => $dkm->id,
            'sender_type' => 'dkm',
            'message' => $request->message,
            'is_read' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => $msg
        ]);
    }
}
