<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [

        'title',
        'slug',

        'hero_title',
        'hero_description',
        'hero_image',

        'seo_title',
        'meta_description',

        'content',
    ];
}