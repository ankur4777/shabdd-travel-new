<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Destination extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'country',
        'category',
        'travel_styles',
        'image_url',
        'badge_label',
        'badge_type',
        'rating',
        'tags',
        'price_from',
        'price_unit',
        'short_description',
        'about',
        'highlights',
        'is_trending',
        'is_active',
        'tagline',
        'hero_image',
        'ideal_days',
        'best_season',
        'formatted_price',
        'price_unit',
        'theme_color',
        'features',
        'seasons',
        'transports',
        'places',
        'packages',
        'city_packages',
        'blogs',
        'testimonials',
        'faqs',
        'popular_for',
        'gallery',
        'testimonials',
        'faqs',
        'location',
        'language',
        'currency',
        'ideal_duration',
        'offer_title',
        'offer_description',
        'discount_percentage',
        'gallery',
        'testimonials',
        'faqs',
        'location',
        'language',
        'currency',
        'ideal_duration',
        'offer_title',
        'offer_description',
        'discount_percentage',
        'image_url',
        'country',
        'price_from',
        'slug',
        'hero_subtitle',
        'overview',

        'why_choose_1',
        'why_choose_2',
        'why_choose_3',
        'why_choose_4',

        'weather',
        'recommended_months',
    ];

    protected $casts = [
        'tags' => 'array',
        'highlights' => 'array',
        'is_trending' => 'boolean',
        'is_active' => 'boolean',
        'rating' => 'decimal:1',
        'features' => 'array',
        'seasons' => 'array',
        'transports' => 'array',
        'places' => 'array',
        'packages' => 'array',
        'city_packages' => 'array',
        'blogs' => 'array',
        'testimonials' => 'array',
        'faqs' => 'array',
        'popular_for' => 'array',
        'travel_styles' => 'array',
        'gallery' => 'array',


    ];

    protected static function booted(): void
    {
        static::saving(function (Destination $destination): void {
            $baseSlug = Str::slug($destination->slug ?: $destination->name);
            $destination->slug = static::generateUniqueSlug($baseSlug ?: Str::random(8), $destination->id);
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeTrending(Builder $query): Builder
    {
        return $query->where('is_trending', true);
    }

    public function getBadgeClassAttribute(): string
    {
        return match ($this->badge_type) {
            'luxury' => 'rd-badge--luxury',
            'bestseller' => 'rd-badge--bestseller',
            default => 'rd-badge--hot',
        };
    }

    public function getFormattedPriceAttribute(): string
    {
        return '₹' . number_format($this->price_from);
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
