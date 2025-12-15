<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, correct any invalid data
        DB::table('clients')
            ->where('occupation', 'eduation')
            ->update(['occupation' => 'other']);

        // Handle any other potential invalid values by setting them to 'other'
        DB::table('clients')
            ->whereNotIn('occupation', [
                'private_sector',
                'public_sector',
                'government',
                'business',
                'education',
                'professional',
                'agriculture',
                'student',
                'doctor',
                'housewife',
                'retired',
                'other'
            ])
            ->whereNotNull('occupation')
            ->update(['occupation' => 'other']);

        // Now modify the enum
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
        Schema::table('clients', function (Blueprint $table) {
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
