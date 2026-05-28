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
        // If you already have a destinations table, use this:
        Schema::table('destinations', function (Blueprint $table) {
            // Check if columns don't already exist before adding them
            if (!Schema::hasColumn('destinations', 'hero_image')) {
                $table->string('hero_image')->nullable()->after('image_url');
            }

            if (!Schema::hasColumn('destinations', 'theme_color')) {
                $table->string('theme_color')->default('primary')->after('hero_image');
            }

            if (!Schema::hasColumn('destinations', 'tagline')) {
                $table->string('tagline')->nullable()->after('name');
            }

            if (!Schema::hasColumn('destinations', 'short_description')) {
                $table->text('short_description')->nullable()->after('description');
            }

            if (!Schema::hasColumn('destinations', 'about')) {
                $table->longText('about')->nullable()->after('short_description');
            }

            if (!Schema::hasColumn('destinations', 'best_season')) {
                $table->string('best_season')->nullable()->after('rating');
            }

            if (!Schema::hasColumn('destinations', 'ideal_days')) {
                $table->string('ideal_days')->nullable()->after('best_season');
            }

            if (!Schema::hasColumn('destinations', 'formatted_price')) {
                $table->string('formatted_price')->nullable()->after('price');
            }

            if (!Schema::hasColumn('destinations', 'price_unit')) {
                $table->string('price_unit')->default('per person')->after('formatted_price');
            }

            if (!Schema::hasColumn('destinations', 'places')) {
                $table->json('places')->nullable()->after('price_unit');
            }

            if (!Schema::hasColumn('destinations', 'packages')) {
                $table->json('packages')->nullable()->after('places');
            }

            if (!Schema::hasColumn('destinations', 'features')) {
                $table->json('features')->nullable()->after('packages');
            }

            if (!Schema::hasColumn('destinations', 'seasons')) {
                $table->json('seasons')->nullable()->after('features');
            }

            if (!Schema::hasColumn('destinations', 'transports')) {
                $table->json('transports')->nullable()->after('seasons');
            }

            // Color customization fields (optional)
            if (!Schema::hasColumn('destinations', 'primary_color')) {
                $table->string('primary_color')->nullable()->after('theme_color');
            }

            if (!Schema::hasColumn('destinations', 'primary_dark')) {
                $table->string('primary_dark')->nullable()->after('primary_color');
            }

            if (!Schema::hasColumn('destinations', 'primary_light')) {
                $table->string('primary_light')->nullable()->after('primary_dark');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumnIfExists([
                'hero_image',
                'theme_color',
                'tagline',
                'short_description',
                'about',
                'best_season',
                'ideal_days',
                'formatted_price',
                'price_unit',
                'places',
                'packages',
                'features',
                'seasons',
                'transports',
                'primary_color',
                'primary_dark',
                'primary_light'
            ]);
        });
    }
};
