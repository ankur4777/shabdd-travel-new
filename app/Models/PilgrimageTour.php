<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PilgrimageTour extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'tags',
        'order',
        'is_active'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
