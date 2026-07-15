<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table): void {
            $table->string('hero_video')->nullable()->after('hero_image');
            $table->text('hero_description')->nullable()->after('hero_subtitle');
            $table->string('hero_primary_text')->nullable()->after('hero_description');
            $table->string('hero_primary_url')->nullable()->after('hero_primary_text');
            $table->string('hero_secondary_text')->nullable()->after('hero_primary_url');
            $table->string('hero_secondary_url')->nullable()->after('hero_secondary_text');
            $table->json('hero_cards')->nullable()->after('hero_secondary_url');
        });
    }

    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table): void {
            $table->dropColumn([
                'hero_video',
                'hero_description',
                'hero_primary_text',
                'hero_primary_url',
                'hero_secondary_text',
                'hero_secondary_url',
                'hero_cards',
            ]);
        });
    }
};
