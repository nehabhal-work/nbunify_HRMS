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
        Schema::table('investment_si', function (Blueprint $table) {
            $table->enum('instruction_type', ['standing', 'schedule'])->default('standing')->after('si_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investment_si', function (Blueprint $table) {
            $table->dropColumn('instruction_type');
        });
    }
};
