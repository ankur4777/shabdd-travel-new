<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('packages', 'type') || !Schema::hasColumn('packages', 'country')) {
            return;
        }

        DB::table('packages')
            ->whereRaw('LOWER(TRIM(COALESCE(type, \'\'))) = ?', ['international'])
            ->whereRaw('TRIM(COALESCE(country, \'\')) = \'\'')
            ->update(['type' => 'domestic']);
    }

    public function down(): void
    {
        //
    }
};
