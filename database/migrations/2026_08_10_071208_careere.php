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
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('job_type');
            $table->unsignedInteger('open_roles')->default(1);
            $table->string('experience');
            $table->string('job_location');
            $table->json('job_roles_responsibilities')->nullable();
            $table->json('required_skills')->nullable();
            $table->json('good_to_have')->nullable();
            $table->json('what_you_get')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
