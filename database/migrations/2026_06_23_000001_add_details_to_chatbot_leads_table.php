<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columns = [
            'trip_type' => 'string',
            'help_type' => 'string',
            'destination' => 'string',
            'travel_date' => 'string',
            'travel_month' => 'string',
            'duration' => 'string',
            'adults' => 'string',
            'children' => 'string',
            'hotel_category' => 'string',
            'flight_required' => 'string',
            'departure_city' => 'string',
            'budget' => 'string',
            'package_need' => 'string',
            'package_type' => 'string',
            'whatsapp_updates' => 'string',
            'name' => 'string',
            'phone' => 'string',
            'email' => 'string',
            'conversation' => 'json',
        ];

        foreach ($columns as $column => $type) {
            if (Schema::hasColumn('chatbot_leads', $column)) {
                continue;
            }

            Schema::table('chatbot_leads', function (Blueprint $table) use ($column, $type) {
                $table->{$type}($column)->nullable();
            });
        }
    }

    public function down(): void
    {
        $columns = [
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

        foreach ($columns as $column) {
            if (! Schema::hasColumn('chatbot_leads', $column)) {
                continue;
            }

            Schema::table('chatbot_leads', function (Blueprint $table) use ($column) {
                $table->dropColumn($column);
            });
        }
    }
};
