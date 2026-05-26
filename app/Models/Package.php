<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image',
        'category',
        'travel_style',
        'days',
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
        'featured',
    ];
}
