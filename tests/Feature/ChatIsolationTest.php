<?php

namespace Tests\Feature;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatIsolationTest extends TestCase
{
    use RefreshDatabase;

    private function approvedDkm(string $email = 'dkm@example.com'): User
    {
        return User::create([
            'name' => 'DKM Admin', 'email' => $email, 'password' => 'secret123',
            'role' => 'dkm_admin', 'masjid_name' => 'Masjid Al-Ikhlas', 'is_approved' => true,
        ]);
    }

    private function otherApprovedDkm(): User
    {
        return User::create([
            'name' => 'DKM Lain', 'email' => 'lain@example.com', 'password' => 'secret123',
            'role' => 'dkm_admin', 'masjid_name' => 'Masjid Lain', 'is_approved' => true,
        ]);
    }

    private function signedGuest(): array
    {
        $data = $this->getJson('/api/chat/guest-token')->assertOk()->json();

        return [$data['guest_token'], $data['signature']];
    }

    public function test_issue_guest_token_returns_token_and_signature(): void
    {
        $this->getJson('/api/chat/guest-token')
            ->assertOk()
            ->assertJsonStructure(['success', 'guest_token', 'signature']);
    }

    public function test_guest_without_signature_is_rejected(): void
    {
        [$token] = $this->signedGuest();
        $dkm = $this->approvedDkm();

        $this->getJson("/api/chat/messages?guest_token={$token}&dkm_id={$dkm->id}")
            ->assertStatus(403);

        $this->postJson('/api/chat/send', [
            'guest_token' => $token,
            'dkm_id' => $dkm->id,
            'message' => 'halo',
        ])->assertStatus(403);
    }

    public function test_guest_cannot_read_or_write_to_unapproved_dkm(): void
    {
        [$token, $sig] = $this->signedGuest();
        $pending = User::create([
            'name' => 'Pending', 'email' => 'p@example.com', 'password' => 'secret123',
            'role' => 'dkm_admin', 'masjid_name' => 'Masjid Pending', 'is_approved' => false,
        ]);

        $this->getJson("/api/chat/messages?guest_token={$token}&signature={$sig}&dkm_id={$pending->id}")
            ->assertStatus(404);

        $this->postJson('/api/chat/send', [
            'guest_token' => $token, 'signature' => $sig,
            'dkm_id' => $pending->id, 'message' => 'halo',
        ])->assertStatus(404);

        $this->assertDatabaseMissing('chat_messages', ['dkm_id' => $pending->id]);
    }

    public function test_guest_can_send_with_valid_signature_and_dkm_receives_it(): void
    {
        [$token, $sig] = $this->signedGuest();
        $dkm = $this->approvedDkm();

        $this->postJson('/api/chat/send', [
            'guest_token' => $token,
            'signature' => $sig,
            'guest_name' => 'Tamu',
            'dkm_id' => $dkm->id,
            'message' => 'Assalamualaikum',
        ])->assertOk();

        $this->assertDatabaseHas('chat_messages', [
            'dkm_id' => $dkm->id, 'guest_token' => $token, 'message' => 'Assalamualaikum',
        ]);
    }

    public function test_dkm_conversations_only_show_own_messages(): void
    {
        [$token] = $this->signedGuest();
        $mine = $this->approvedDkm();
        $other = $this->otherApprovedDkm();

        ChatMessage::create([
            'guest_token' => $token, 'guest_name' => 'Tamu', 'dkm_id' => $mine->id,
            'sender_type' => 'guest', 'message' => 'for mine', 'is_read' => false,
        ]);
        ChatMessage::create([
            'guest_token' => $token, 'guest_name' => 'Tamu', 'dkm_id' => $other->id,
            'sender_type' => 'guest', 'message' => 'for other', 'is_read' => false,
        ]);

        $conversations = $this->actingAs($mine)->getJson('/dkm/api/conversations')
            ->assertOk()
            ->json('conversations');

        $this->assertCount(1, $conversations);
        $this->assertSame('for mine', $conversations[0]['last_message']);
    }

    public function test_dkm_cannot_read_or_reply_to_other_dkm_conversation(): void
    {
        [$token] = $this->signedGuest();
        $mine = $this->approvedDkm();
        $other = $this->otherApprovedDkm();

        ChatMessage::create([
            'guest_token' => $token, 'guest_name' => 'Tamu', 'dkm_id' => $other->id,
            'sender_type' => 'guest', 'message' => 'private', 'is_read' => false,
        ]);

        $messages = $this->actingAs($mine)->getJson("/dkm/api/messages/{$token}")
            ->assertOk()
            ->json('messages');
        $this->assertCount(0, $messages);

        $this->actingAs($mine)->postJson('/dkm/api/reply', [
            'guest_token' => $token,
            'message' => 'reply attempt',
        ])->assertOk();

        // The reply is tagged with the acting DKM's id, not the other DKM's.
        $this->assertDatabaseHas('chat_messages', [
            'guest_token' => $token, 'dkm_id' => $mine->id, 'message' => 'reply attempt',
        ]);
        $this->assertSame(
            1,
            ChatMessage::where('guest_token', $token)->where('message', 'private')->count()
        );
    }

    public function test_dkm_marking_read_only_affects_own_messages(): void
    {
        [$token] = $this->signedGuest();
        $mine = $this->approvedDkm();
        $other = $this->otherApprovedDkm();

        ChatMessage::create([
            'guest_token' => $token, 'guest_name' => 'Tamu', 'dkm_id' => $mine->id,
            'sender_type' => 'guest', 'message' => 'mine', 'is_read' => false,
        ]);
        ChatMessage::create([
            'guest_token' => $token, 'guest_name' => 'Tamu', 'dkm_id' => $other->id,
            'sender_type' => 'guest', 'message' => 'theirs', 'is_read' => false,
        ]);

        $this->actingAs($mine)->getJson("/dkm/api/messages/{$token}")->assertOk();

        $this->assertTrue((bool) ChatMessage::where('dkm_id', $mine->id)->value('is_read'));
        $this->assertFalse((bool) ChatMessage::where('dkm_id', $other->id)->value('is_read'));
    }
}
