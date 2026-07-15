<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('destinations', 'type')) {
            return;
        }

        DB::table('destinations')
            ->whereRaw('TRIM(COALESCE(type, \'\')) = \'\'')
            ->whereRaw('LOWER(TRIM(COALESCE(country, \'\'))) = ?', ['india'])
            ->update(['type' => 'domestic']);

        DB::table('destinations')
            ->whereRaw('TRIM(COALESCE(type, \'\')) = \'\'')
            ->whereRaw('LOWER(TRIM(COALESCE(country, \'\'))) != ?', ['india'])
            ->update(['type' => 'international']);
    }

    public function down(): void
    {
        //
    }
};
