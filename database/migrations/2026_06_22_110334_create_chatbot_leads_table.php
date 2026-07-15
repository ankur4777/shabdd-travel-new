<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('chatbot_leads', function (Blueprint $table) {

        $table->id();

        $table->string('trip_type')->nullable();
        $table->string('help_type')->nullable();

        $table->string('destination')->nullable();

        $table->string('travel_date')->nullable();
        $table->string('travel_month')->nullable();

        $table->string('duration')->nullable();

        $table->string('adults')->nullable();
        $table->string('children')->nullable();

        $table->string('hotel_category')->nullable();

        $table->string('flight_required')->nullable();

        $table->string('departure_city')->nullable();

        $table->string('budget')->nullable();

        $table->string('package_need')->nullable();

        $table->string('package_type')->nullable();

        $table->string('whatsapp_updates')->nullable();

        $table->string('name')->nullable();
        $table->string('phone')->nullable();
        $table->string('email')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_leads');
    }
};
