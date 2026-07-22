<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'compare_price',
        'cost_price',
        'stock',
        'sku',
        'barcode',
        'category',
        'brand',
        'tags',
        'status',
        'is_active',
        'is_featured',
        'is_on_sale',
        'discount_percentage',
        'discount_start',
        'discount_end',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_on_sale' => 'boolean',
        'discount_start' => 'datetime',
        'discount_end' => 'datetime',
        'tags' => 'array',
    ];

    // 🔥 RELACIÓN CON IMÁGENES
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    // 🔥 RELACIÓN CON IMAGEN PRINCIPAL
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // 🔥 SCOPES
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOnSale($query)
    {
        return $query->whereNotNull('discount_percentage')
                     ->where('discount_percentage', '>', 0);
    }

    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->where('stock', '<=', $threshold);
    }

    // 🔥 ACCESSORS
    public function getFinalPriceAttribute(): float
    {
        if ($this->is_on_sale && $this->discount_percentage) {
            return $this->price - ($this->price * ($this->discount_percentage / 100));
        }
        return $this->price;
    }

    public function getProfitMarginAttribute(): ?float
    {
        if ($this->cost_price && $this->price) {
            return (($this->price - $this->cost_price) / $this->price) * 100;
        }
        return null;
    }

    // 🔥 MUTATORS
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}