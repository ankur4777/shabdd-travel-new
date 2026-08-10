<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            if (!Schema::hasColumn('destinations', 'is_seasonal_journey')) {
                $table->boolean('is_seasonal_journey')->default(false)->after('is_trending');
            }
        });
    }

    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            if (Schema::hasColumn('destinations', 'is_seasonal_journey')) {
                $table->dropColumn('is_seasonal_journey');
            }
        });
    }
};
