<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = [
        'title',
        'job_type',
        'open_roles',
        'experience',
        'job_location',
        'job_roles_responsibilities',
        'required_skills',
        'good_to_have',
        'what_you_get',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'open_roles' => 'integer',
            'job_roles_responsibilities' => 'array',
            'required_skills' => 'array',
            'good_to_have' => 'array',
            'what_you_get' => 'array',
            'is_active' => 'boolean',
        ];
    }
}
