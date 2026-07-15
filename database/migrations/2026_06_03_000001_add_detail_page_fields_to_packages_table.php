<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->longText('detail_overview')->nullable()->after('description');
            $table->json('detail_highlights')->nullable()->after('detail_overview');
            $table->json('detail_gallery')->nullable()->after('detail_highlights');
            $table->string('hotel_name')->nullable()->after('detail_gallery');
            $table->string('hotel_category')->nullable()->after('hotel_name');
            $table->string('hotel_area')->nullable()->after('hotel_category');
            $table->string('hotel_image')->nullable()->after('hotel_area');
            $table->json('hotel_highlights')->nullable()->after('hotel_image');
            $table->json('itinerary')->nullable()->after('hotel_highlights');
            $table->json('inclusions')->nullable()->after('itinerary');
            $table->json('exclusions')->nullable()->after('inclusions');
        });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn([
                'detail_overview',
                'detail_highlights',
                'detail_gallery',
                'hotel_name',
                'hotel_category',
                'hotel_area',
                'hotel_image',
                'hotel_highlights',
                'itinerary',
                'inclusions',
                'exclusions',
            ]);
        });
    }
};
