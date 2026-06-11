<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeasonalJourney extends Model
{
    protected $fillable = [
        'name',
        'price',
        'image',
        'url',
        'card_size',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Card size key → CSS class mapping.
     * Matches exactly the classes used in your sj-grid.
     */
    public static function cardSizeOptions(): array
    {
        return [
            'sj-card--wide-left'    => 'Wide Left (top-left, large)',
            'sj-card--tall-center'  => 'Tall Center (spans both rows)',
            'sj-card--wide-right'   => 'Wide Right (top-right, small)',
            'sj-card--bottom-sm'    => 'Bottom Small (bottom row)',
            'sj-card--bottom-right' => 'Bottom Right (bottom row, small)',
        ];
    }

    /** Convenience: full URL for the stored image */
    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }

    /** Active records ordered for display */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}