<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany; // 🔥 NUEVO

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'is_published',
        'featured_image',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'post_category');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    // 🔥 NUEVA RELACIÓN: COMENTARIOS
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->where('is_approved', true);
    }

    public function allComments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}