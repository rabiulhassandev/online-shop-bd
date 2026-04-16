<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'image',
        'title',
        'subtitle',
        'button_text',
        'button_link',
        'sort_order',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Scope: only active sliders ordered by sort_order.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Get the slider image URL.
     */
    public function getImageUrlAttribute(): string
    {
        return asset('storage/'.$this->image);
    }
}
