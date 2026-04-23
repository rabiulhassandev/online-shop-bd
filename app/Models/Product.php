<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
        'images',
        'price',
        'discounted_price',
        'discount_start_at',
        'discount_end_at',
        'sizes',
        'colors',
        'total_stock',
        'is_featured',
        'is_new_arrival',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'images' => 'array',
            'sizes' => 'array',
            'colors' => 'array',
            'price' => 'decimal:2',
            'discounted_price' => 'decimal:2',
            'discount_start_at' => 'datetime',
            'discount_end_at' => 'datetime',
            'is_featured' => 'boolean',
            'is_new_arrival' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Use slug for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the category of this product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get reviews for this product.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get only approved reviews.
     */
    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }

    /**
     * Scope: only active products.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: only featured products.
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: only new arrivals.
     */
    public function scopeNewArrival(Builder $query): Builder
    {
        return $query->where('is_new_arrival', true);
    }

    /**
     * Check if product has an active discount right now.
     */
    public function hasActiveDiscount(): bool
    {
        if (! $this->discounted_price || $this->discounted_price >= $this->price) {
            return false;
        }

        $now = now();

        if ($this->discount_start_at && $now->lt($this->discount_start_at)) {
            return false;
        }

        if ($this->discount_end_at && $now->gt($this->discount_end_at)) {
            return false;
        }

        return true;
    }

    /**
     * Get the current effective price.
     */
    public function getEffectivePriceAttribute(): float
    {
        return $this->hasActiveDiscount() ? (float) $this->discounted_price : (float) $this->price;
    }

    /**
     * Get discount percentage.
     */
    public function getDiscountPercentAttribute(): int
    {
        if (! $this->hasActiveDiscount()) {
            return 0;
        }

        return (int) round((($this->price - $this->discounted_price) / $this->price) * 100);
    }

    /**
     * Get the primary image URL.
     */
    public function getPrimaryImageAttribute(): string
    {
        $images = $this->images ?? [];

        return count($images) > 0 ? asset('storage/'.$images[0]) : asset('images/placeholder.jpg');
    }
}
