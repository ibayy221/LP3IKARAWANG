<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PasswordReset extends Model
{
    protected $fillable = ['user_id', 'email', 'code', 'expires_at', 'used'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Check if code is valid (not expired and not used)
    public function isValid(): bool
    {
        return !$this->used && $this->expires_at > now();
    }

    // Scope untuk mendapatkan kode yang masih berlaku
    public function scopeValid($query)
    {
        return $query->where('used', false)->where('expires_at', '>', now());
    }

    // Generate random 6-digit code
    public static function generateCode(): string
    {
        return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    // Create new password reset
    public static function createReset($user_id, $email): self
    {
        // Delete old unused codes
        self::where('user_id', $user_id)
            ->where('used', false)
            ->delete();

        return self::create([
            'user_id' => $user_id,
            'email' => $email,
            'code' => self::generateCode(),
            'expires_at' => now()->addMinutes(30),
        ]);
    }
}
