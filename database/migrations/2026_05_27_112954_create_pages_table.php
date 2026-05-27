<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {

            $table->id();

            $table->string('title');

            $table->string('slug')->unique();

            /* HERO SECTION */

            $table->string('hero_title')->nullable();

            $table->text('hero_description')->nullable();

            $table->string('hero_image')->nullable();

            /* SEO */

            $table->string('seo_title')->nullable();

            $table->text('meta_description')->nullable();

            /* MAIN CONTENT */

            $table->longText('content')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};