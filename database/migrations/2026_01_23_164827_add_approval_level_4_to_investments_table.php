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
        Schema::table('investments', function (Blueprint $table) {
            $table->unsignedBigInteger('approved4_by')->nullable()->after('approved3_on');
            $table->timestamp('approved4_on')->nullable()->after('approved4_by');
            
            $table->foreign('approved4_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investments', function (Blueprint $table) {
            $table->dropForeign(['approved4_by']);
            $table->dropColumn(['approved4_by', 'approved4_on']);
        });
    }
};
