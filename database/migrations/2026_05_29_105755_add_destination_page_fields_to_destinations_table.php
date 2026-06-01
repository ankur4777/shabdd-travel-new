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
        Schema::table('destinations', function (Blueprint $table) {

            $table->string('hero_subtitle')->nullable();
            // $table->string('hero_image')->nullable();

            $table->longText('overview')->nullable();

            $table->string('why_choose_1')->nullable();
            $table->string('why_choose_2')->nullable();
            $table->string('why_choose_3')->nullable();
            $table->string('why_choose_4')->nullable();

            $table->string('best_season')->nullable();
            $table->string('weather')->nullable();
            $table->string('recommended_months')->nullable();

            $table->string('location')->nullable();
            $table->string('language')->nullable();
            $table->string('currency')->nullable();
            $table->string('ideal_duration')->nullable();

            $table->string('offer_title')->nullable();
            $table->text('offer_description')->nullable();
            $table->string('discount_percentage')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {

            $table->dropColumn([
                'hero_subtitle',
                'hero_image',
                'overview',

                'why_choose_1',
                'why_choose_2',
                'why_choose_3',
                'why_choose_4',

                'best_season',
                'weather',
                'recommended_months',

                'location',
                'language',
                'currency',
                'ideal_duration',

                'offer_title',
                'offer_description',
                'discount_percentage',
            ]);
        });
    }
};
