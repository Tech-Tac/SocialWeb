<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sender_id',
        'type',
        'target_id',
        'unread'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function target(): BelongsTo
    {
        if ($this->type === "friend_request" || $this->type === "friend_accept") {
            return $this->belongsTo(User::class);
        } else if ($this->type === "comment_like" || $this->type === "reply" || $this->type === "comment") {
            return $this->belongsTo(Comment::class);
        } else if ($this->type === "post_like") {
            return $this->belongsTo(Post::class);
        } else if ($this->type === "invite") {
            return $this->belongsTo(Group::class);
        }
    }
}
