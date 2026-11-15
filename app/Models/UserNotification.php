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
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    // Raccourci : UserNotification::send($userId, 'Votre rendez-vous est confirmé.')
    public static function send(int $userId, string $message): self
    {
        return self::create(['user_id' => $userId, 'message' => $message]);
    }
}