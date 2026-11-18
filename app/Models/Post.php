<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $guarded = [];

    protected $casts = ['published_at' => 'datetime', 'noindex' => 'boolean'];

    public function scopePublished($q)
    {
        return $q->where('status', 'published')->where(fn ($w) => $w->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    public function getIsLiveAttribute(): bool
    {
        return $this->status === 'published' && (! $this->published_at || $this->published_at->lte(now()));
    }

    /** Public URL of an image stored relative to /public (or an absolute URL). */
    public static function img(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        return Str::startsWith($path, ['http://', 'https://']) ? $path : asset($path);
    }

    public function getCoverUrlAttribute(): ?string
    {
        return self::img($this->cover_image);
    }

    public function getSeoTitleAttribute(): string
    {
        return $this->meta_title ?: $this->title;
    }

    public function getSeoDescriptionAttribute(): string
    {
        return $this->meta_description ?: Str::limit(trim(strip_tags($this->excerpt ?: (string) $this->content)), 155);
    }

    public static function readMinutes(?string $html): int
    {
        return max(1, (int) ceil(str_word_count(strip_tags((string) $html)) / 200));
    }
}
