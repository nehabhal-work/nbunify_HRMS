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
            $table->string('res_country_code', 255)->nullable()->after('res_country');
            $table->string('res_state_code', 255)->nullable()->after('res_state');
            $table->string('res_city_code', 255)->nullable()->after('res_city');

            $table->string('office_country_code', 255)->nullable()->after('office_country');
            $table->string('office_state_code', 255)->nullable()->after('office_state');
            $table->string('office_city_code', 255)->nullable()->after('office_city');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_families', function (Blueprint $table) {});
    }
};
