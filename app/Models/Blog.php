<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'destination_id',
        'title',
        'slug',
        'image',
        'image_alt_text',
        'category',
        'excerpt',
        'content',
        'highlights',
        'quick_facts',
        'itinerary',
        'faqs',
        'author',
        'role',
        'reading_time',
        'published_at',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'highlights' => 'array',
        'quick_facts' => 'array',
        'itinerary' => 'array',
        'faqs' => 'array',
        'published_at' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Blog $blog): void {
            $baseSlug = Str::slug($blog->slug ?: $blog->title);
            $blog->slug = static::generateUniqueSlug($baseSlug ?: Str::random(8), $blog->id);
        });
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    private static function generateUniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $slug = $baseSlug;
        $counter = 2;

        while (static::query()
            ->when($ignoreId, fn (Builder $query) => $query->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
