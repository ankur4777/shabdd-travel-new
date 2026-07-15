<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('packages', 'type')) {
            return;
        }

        DB::table('packages')
            ->whereRaw('TRIM(COALESCE(type, \'\')) = \'\'')
            ->where(function ($query): void {
                $query
                    ->whereRaw('TRIM(COALESCE(country, \'\')) = \'\'')
                    ->orWhereRaw('LOWER(TRIM(COALESCE(country, \'\'))) = ?', ['india']);
            })
            ->update(['type' => 'domestic']);

        DB::table('packages')
            ->whereRaw('TRIM(COALESCE(type, \'\')) = \'\'')
            ->whereRaw('TRIM(COALESCE(country, \'\')) != \'\'')
            ->whereRaw('LOWER(TRIM(COALESCE(country, \'\'))) != ?', ['india'])
            ->update(['type' => 'international']);
    }

    public function down(): void
    {
        //
    }
};
