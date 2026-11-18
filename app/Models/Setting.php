<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/** Tiny key/value store for admin-editable site settings (cached; safe before migrations run). */
class Setting extends Model
{
    protected $guarded = [];

    private static function all_(): array
    {
        return Cache::rememberForever('site_settings', fn () => static::query()->pluck('value', 'key')->all());
    }

    public static function get(string $key, $default = null)
    {
        try {
            $v = self::all_()[$key] ?? null;

            return ($v === null || $v === '') ? $default : $v;
        } catch (\Throwable $e) {
            return $default; // table not created yet
        }
    }

    public static function put(array $pairs): void
    {
        foreach ($pairs as $k => $v) {
            static::updateOrCreate(['key' => $k], ['value' => $v]);
        }
        Cache::forget('site_settings');
    }

    public static function comingSoon(): bool
    {
        return self::get('coming_soon', '0') === '1';
    }
}
