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

        $table->json('gallery')->nullable();

        $table->json('testimonials')->nullable();

        $table->json('faqs')->nullable();

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
            //
        });
    }
};
