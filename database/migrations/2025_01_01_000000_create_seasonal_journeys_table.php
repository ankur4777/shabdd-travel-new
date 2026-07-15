<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('seasonal_journeys')) {
            return;
        }

        Schema::create('seasonal_journeys', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->string('price_text')->nullable();
            $table->text('excerpt')->nullable();
            $table->text('content')->nullable();
            $table->string('name')->nullable();
            $table->string('price')->nullable();
            $table->string('url')->default('#');
            $table->string('card_size')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seasonal_journeys');
    }
};
