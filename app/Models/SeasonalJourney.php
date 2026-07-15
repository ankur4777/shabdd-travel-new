<?php

namespace App\Models;

use App\Support\MediaUrl;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class SeasonalJourney extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image',
        'hero_image',
        'price_text',
        'excerpt',
        'content',
        'tagline',
        'overview',
        'best_season',
        'ideal_duration',
        'location',
        'climate',
        'popular_for',
        'highlights',
        'seasons',
        'gallery',
        'testimonials',
        'faqs',
        'offer_title',
        'offer_description',
        'discount_percentage',
        'why_choose_1',
        'why_choose_2',
        'why_choose_3',
        'why_choose_4',
        'meta_title',
        'meta_description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'popular_for' => 'array',
        'highlights' => 'array',
        'seasons' => 'array',
        'gallery' => 'array',
        'testimonials' => 'array',
        'faqs' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (SeasonalJourney $journey): void {
            $baseSlug = Str::slug($journey->slug ?: $journey->title);
            $journey->slug = static::generateUniqueSlug($baseSlug ?: Str::random(8), $journey->id);
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getImageUrlAttribute()
    {
        return MediaUrl::asset($this->image, MediaUrl::DEFAULT_SEASONAL_IMAGE);
    }

    public function getHeroImageUrlAttribute(): string
    {
        return $this->resolveMediaUrl($this->hero_image ?: $this->image);
    }

    public function resolveMediaUrl(?string $path): string
    {
        return MediaUrl::asset($path, MediaUrl::DEFAULT_SEASONAL_IMAGE);
    }

    private static function generateUniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $slug = $baseSlug;
        $counter = 2;

        while (static::query()
            ->when($ignoreId, fn(Builder $query) => $query->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
