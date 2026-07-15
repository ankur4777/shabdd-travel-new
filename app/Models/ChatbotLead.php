<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotLead extends Model
{
    protected $fillable = [
        'trip_type',
        'help_type',
        'destination',
        'travel_date',
        'travel_month',
        'duration',
        'adults',
        'children',
        'hotel_category',
        'flight_required',
        'departure_city',
        'budget',
        'package_need',
        'package_type',
        'whatsapp_updates',
        'name',
        'phone',
        'email',
        'conversation',
    ];

    protected $casts = [
        'conversation' => 'array',
    ];
}
