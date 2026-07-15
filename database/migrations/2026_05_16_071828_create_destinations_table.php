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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('country');
            $table->string('image_url');
            $table->string('badge_label')->nullable();
            $table->string('badge_type')->default('hot');
            $table->decimal('rating', 2, 1)->default(4.5);
            $table->json('tags')->nullable();
            $table->unsignedInteger('price_from');
            $table->string('price_unit')->default('/Adult');
            $table->text('short_description')->nullable();
            $table->longText('about')->nullable();
            $table->json('highlights')->nullable();
            $table->boolean('is_trending')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
