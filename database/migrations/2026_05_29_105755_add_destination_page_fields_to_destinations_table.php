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

        $table->string('why_choose_1')->nullable();
        $table->string('why_choose_2')->nullable();
        $table->string('why_choose_3')->nullable();
        $table->string('why_choose_4')->nullable();

        $table->string('weather')->nullable();
        $table->string('recommended_months')->nullable();

    });
}

    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::table('destinations', function (Blueprint $table) {

        $table->dropColumn([
            'why_choose_1',
            'why_choose_2',
            'why_choose_3',
            'why_choose_4',
            'weather',
            'recommended_months',
        ]);

    });
}
};
