<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image',
        'category',
        'type',
        'travel_style',
        'days',
        'country',
        'state',
        'city',
        'duration_text',
        'rating',
        'price',
        'old_price',
        'flight',
        'theme',
        'feature_1',
        'feature_2',
        'feature_3',
        'description',
        'summer_vacation_special',
        'winter_vacation_special',
        'monsoon_special',
        'detail_overview',
        'detail_highlights',
        'detail_gallery',
        'hotel_name',
        'hotel_category',
        'hotel_area',
        'hotel_image',
        'hotel_highlights',
        'itinerary',
        'inclusions',
        'exclusions',
        'faqs',
        'pdf_file',
        'featured',
        'is_trending',
    ];

    protected $casts = [
        'detail_highlights' => 'array',
        'detail_gallery' => 'array',
        'hotel_highlights' => 'array',
        'itinerary' => 'array',
        'inclusions' => 'array',
        'exclusions' => 'array',
        'faqs' => 'array',
        'featured' => 'boolean',
        'is_trending' => 'boolean',
        'summer_vacation_special' => 'boolean',
        'winter_vacation_special' => 'boolean',
        'monsoon_special' => 'boolean',
    ];

    public function scopeDomestic(Builder $query): Builder
    {
        return $query->whereRaw('LOWER(COALESCE(type, \'\')) = ?', ['domestic']);
    }

    public function scopeInternational(Builder $query): Builder
    {
        return $query->whereRaw('LOWER(COALESCE(type, \'\')) = ?', ['international']);
    }

    public function scopeSeasonSpecial(Builder $query, string $seasonColumn): Builder
    {
        return $query->where($seasonColumn, true);
    }
}
