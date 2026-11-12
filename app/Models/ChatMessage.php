<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_token',
        'guest_name',
        'dkm_id',
        'sender_type',
        'message',
        'is_read',
    ];

    public function dkm()
    {
        return $this->belongsTo(User::class, 'dkm_id');
    }

    /**
     * Build the guest conversation list for a DKM in a single query:
     * one grouped subquery per guest with the latest message and unread count,
     * instead of two extra queries per guest (N+1).
     *
     * @param int $dkmId
     * @return \Illuminate\Support\Collection<int, array{guest_token: string, guest_name: string, last_message: string, last_time: ?\Illuminate\Support\Carbon\Carbon, unread_count: int}>
     */
    public static function conversationsForDkm(int $dkmId)
    {
        return self::query()
            ->where('dkm_id', $dkmId)
            ->orderBy('created_at')
            ->get()
            ->groupBy('guest_token')
            ->map(function ($messages) {
                $last = $messages->last();

                return [
                    'guest_token' => $last->guest_token,
                    'guest_name' => $messages->first()->guest_name,
                    'last_message' => $last->message,
                    'last_time' => $last->created_at,
                    'unread_count' => $messages
                        ->where('sender_type', 'guest')
                        ->where('is_read', false)
                        ->count(),
                ];
            })
            ->sortByDesc('last_time')
            ->values();
    }
}
