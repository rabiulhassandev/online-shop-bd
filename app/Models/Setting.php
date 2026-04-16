<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    /** @var list<string> */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Get a setting value by key with optional default.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = Cache::remember('app_settings', 3600, function () {
            return static::pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    /**
     * Set a setting value by key.
     */
    public static function set(string $key, ?string $value): void
    {
        static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget('app_settings');
    }

    /**
     * Set multiple settings at once.
     *
     * @param  array<string, string|null>  $settings
     */
    public static function setMany(array $settings): void
    {
        foreach ($settings as $key => $value) {
            static::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        Cache::forget('app_settings');
    }
}
