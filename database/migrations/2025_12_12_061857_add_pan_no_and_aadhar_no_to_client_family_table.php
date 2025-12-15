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
        Schema::table('client_families', function (Blueprint $table) {
            $table->string('pan_no', 10)->nullable()->after('email');
            $table->string('aadhar_no', 12)->nullable()->after('pan_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_families', function (Blueprint $table) {
            $table->dropColumn(['pan_no', 'aadhar_no']);
        });
    }
};
