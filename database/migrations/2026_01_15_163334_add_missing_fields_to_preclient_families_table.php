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
        Schema::table('preclient_families', function (Blueprint $table) {
            $table->string('client_code', 20)->nullable()->after('id');
            $table->string('pan_no', 10)->nullable()->after('email');
            $table->string('aadhar_no', 12)->nullable()->after('pan_no');
            $table->string('res_country_code')->nullable()->after('res_country');
            $table->string('res_state_code')->nullable()->after('res_state');
            $table->string('res_city_code')->nullable()->after('res_city');
            $table->string('office_country_code')->nullable()->after('office_country');
            $table->string('office_state_code')->nullable()->after('office_state');
            $table->string('office_city_code')->nullable()->after('office_city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('preclient_families', function (Blueprint $table) {
            $table->dropColumn([
                'client_code',
                'pan_no',
                'aadhar_no',
                'res_country_code',
                'res_state_code',
                'res_city_code',
                'office_country_code',
                'office_state_code',
                'office_city_code'
            ]);
        });
    }
};
