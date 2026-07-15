<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seasonal_journeys', function (Blueprint $table) {
            if (!Schema::hasColumn('seasonal_journeys', 'hero_image')) {
                $table->string('hero_image')->nullable()->after('image');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'tagline')) {
                $table->string('tagline')->nullable()->after('content');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'overview')) {
                $table->longText('overview')->nullable()->after('tagline');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'best_season')) {
                $table->string('best_season')->nullable()->after('overview');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'ideal_duration')) {
                $table->string('ideal_duration')->nullable()->after('best_season');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'location')) {
                $table->string('location')->nullable()->after('ideal_duration');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'climate')) {
                $table->string('climate')->nullable()->after('location');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'popular_for')) {
                $table->json('popular_for')->nullable()->after('climate');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'highlights')) {
                $table->json('highlights')->nullable()->after('popular_for');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'seasons')) {
                $table->json('seasons')->nullable()->after('highlights');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'gallery')) {
                $table->json('gallery')->nullable()->after('seasons');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'testimonials')) {
                $table->json('testimonials')->nullable()->after('gallery');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'faqs')) {
                $table->json('faqs')->nullable()->after('testimonials');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'offer_title')) {
                $table->string('offer_title')->nullable()->after('faqs');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'offer_description')) {
                $table->text('offer_description')->nullable()->after('offer_title');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'discount_percentage')) {
                $table->string('discount_percentage')->nullable()->after('offer_description');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'why_choose_1')) {
                $table->text('why_choose_1')->nullable()->after('discount_percentage');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'why_choose_2')) {
                $table->text('why_choose_2')->nullable()->after('why_choose_1');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'why_choose_3')) {
                $table->text('why_choose_3')->nullable()->after('why_choose_2');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'why_choose_4')) {
                $table->text('why_choose_4')->nullable()->after('why_choose_3');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'meta_title')) {
                $table->string('meta_title')->nullable()->after('why_choose_4');
            }

            if (!Schema::hasColumn('seasonal_journeys', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }
        });
    }

    public function down(): void
    {
        Schema::table('seasonal_journeys', function (Blueprint $table) {
            $columns = [
                'hero_image',
                'tagline',
                'overview',
                'best_season',
                'ideal_duration',
                'location',
                'climate',
                'popular_for',
                'highlights',
                'seasons',
                'gallery',
                'testimonials',
                'faqs',
                'offer_title',
                'offer_description',
                'discount_percentage',
                'why_choose_1',
                'why_choose_2',
                'why_choose_3',
                'why_choose_4',
                'meta_title',
                'meta_description',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('seasonal_journeys', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
