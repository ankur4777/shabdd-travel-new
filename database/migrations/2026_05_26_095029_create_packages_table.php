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
        Schema::create('packages', function (Blueprint $table) {

            $table->id();

            $table->string('title');

            $table->string('slug')->unique();

            $table->string('image')->nullable();

            $table->string('category')->nullable();

            $table->string('travel_style')->nullable();

            $table->integer('days')->nullable();

            $table->string('duration_text')->nullable();

            $table->decimal('rating', 2, 1)->nullable();

            $table->integer('price');

            $table->integer('old_price')->nullable();

            $table->string('flight')->nullable();

            $table->string('theme')->nullable();

            $table->text('feature_1')->nullable();

            $table->text('feature_2')->nullable();

            $table->text('feature_3')->nullable();

            $table->longText('description')->nullable();

            $table->boolean('featured')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
