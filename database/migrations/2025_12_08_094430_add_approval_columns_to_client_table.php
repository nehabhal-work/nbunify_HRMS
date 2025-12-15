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
            $table->unsignedBigInteger('approved2_by')->nullable();
            $table->timestamp('approved2_on')->nullable();
            $table->unsignedBigInteger('approved3_by')->nullable();
            $table->timestamp('approved3_on')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['approved2_by', 'approved2_on', 'approved3_by', 'approved3_on']);
        });
    }
};
