// database/migrations/xxxx_create_seasonal_journeys_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seasonal_journeys', function (Blueprint $table) {
            $table->id();
            $table->string('name');               // e.g. "ANDAMAN"
            $table->string('price');              // e.g. "14,999"
            $table->string('image');              // storage path
            $table->string('url')->default('#');  // destination link
            $table->string('card_size');          // bento layout class key
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