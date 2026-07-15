<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('seasonal_journeys')) {
            Schema::table('seasonal_journeys', function (Blueprint $table) {
                if (!Schema::hasColumn('seasonal_journeys', 'title')) {
                    $table->string('title')->nullable();
                }

                if (!Schema::hasColumn('seasonal_journeys', 'slug')) {
                    $table->string('slug')->nullable()->unique();
                }

                if (!Schema::hasColumn('seasonal_journeys', 'image')) {
                    $table->string('image')->nullable();
                }

                if (!Schema::hasColumn('seasonal_journeys', 'price_text')) {
                    $table->string('price_text')->nullable();
                }

                if (!Schema::hasColumn('seasonal_journeys', 'excerpt')) {
                    $table->text('excerpt')->nullable();
                }

                if (!Schema::hasColumn('seasonal_journeys', 'content')) {
                    $table->text('content')->nullable();
                }

                if (!Schema::hasColumn('seasonal_journeys', 'is_active')) {
                    $table->boolean('is_active')->default(true);
                }

                if (!Schema::hasColumn('seasonal_journeys', 'sort_order')) {
                    $table->integer('sort_order')->default(0);
                }

                if (!Schema::hasColumn('seasonal_journeys', 'created_at')) {
                    $table->timestamps();
                }
            });

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
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seasonal_journeys');
    }
};
