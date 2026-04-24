<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Upazila extends Model
{
    protected $fillable = ['district_id', 'name', 'bn_name', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function division(): BelongsTo
    {
        return $this->district->division();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
