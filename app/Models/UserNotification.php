<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserNotification extends Model
{
    protected $fillable = ['user_id', 'message', 'is_read'];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // Une notification appartient à un utilisateur
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Raccourci pour créer une notification
    public static function send(int $userId, string $message): self
    {
        return self::create(['user_id' => $userId, 'message' => $message]);
    }
}