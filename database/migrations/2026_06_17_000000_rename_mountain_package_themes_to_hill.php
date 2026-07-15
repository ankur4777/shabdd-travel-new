<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('packages')
            ->whereRaw("LOWER(TRIM(COALESCE(theme, ''))) = ?", ['mountain'])
            ->update(['theme' => 'Hill']);
    }

    public function down(): void
    {
        DB::table('packages')
            ->whereRaw("LOWER(TRIM(COALESCE(theme, ''))) = ?", ['hill'])
            ->update(['theme' => 'Mountain']);
    }
};
