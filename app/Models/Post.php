<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable =['user_id', 'title', 'content', 'is_published'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
