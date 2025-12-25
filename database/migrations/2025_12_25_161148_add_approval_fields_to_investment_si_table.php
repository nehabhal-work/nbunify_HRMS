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
            $table->unsignedBigInteger('created_by')->nullable()->after('remarks');
            $table->unsignedBigInteger('approved_by')->nullable()->after('created_by');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->unsignedBigInteger('approved2_by')->nullable()->after('approved_at');
            $table->timestamp('approved2_on')->nullable()->after('approved2_by');
            $table->unsignedBigInteger('approved3_by')->nullable()->after('approved2_on');
            $table->timestamp('approved3_on')->nullable()->after('approved3_by');
            
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('approved2_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('approved3_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investment_si', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['approved2_by']);
            $table->dropForeign(['approved3_by']);
            $table->dropColumn(['created_by', 'approved_by', 'approved_at', 'approved2_by', 'approved2_on', 'approved3_by', 'approved3_on']);
        });
    }
};
