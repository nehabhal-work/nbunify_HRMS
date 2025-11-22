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
        Schema::table('client_banks', function (Blueprint $table) {
            $table->string('attachment_cancelled_cheque')->nullable()->after('account_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_banks', function (Blueprint $table) {
            $table->dropColumn('attachment_cancelled_cheque');
        });
    }
};
