<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'masjid_name',
        'phone_number',
        'address',
        'is_approved',
        'rejected_at',
        'rejection_reason',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_approved' => 'boolean',
            'rejected_at' => 'datetime',
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isDkmAdmin(): bool
    {
        return $this->role === 'dkm_admin';
    }

    public function isRejected(): bool
    {
        return $this->rejected_at !== null;
    }

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class, 'dkm_id');
    }
}
