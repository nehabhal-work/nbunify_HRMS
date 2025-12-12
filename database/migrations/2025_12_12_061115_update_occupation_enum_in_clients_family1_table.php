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
        Schema::table('clients', function (Blueprint $table) {
            $table->enum('occupation', [
                'private_sector',
                'public_sector',
                'government',
                'business',
                'education',   // corrected spelling
                'professional',
                'agriculture',
                'student',
                'doctor',
                'housewife',
                'retired',
                'other'
            ])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_families', function (Blueprint $table) {
            $table->enum('occupation', [
                'private_sector',
                'public_sector',
                'government',
                'business',
                'eduation',   // revert to incorrect spelling
                'professional',
                'agriculture',
                'student',
                'doctor',
                'housewife',
                'retired',
                'other'
            ])->nullable()->change();
        });
    }
};
