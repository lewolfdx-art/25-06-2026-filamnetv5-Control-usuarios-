<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
        'content',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    // 🔥 USUARIO QUE COMENTA
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // 🔥 POST DONDE SE COMENTÓ
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}