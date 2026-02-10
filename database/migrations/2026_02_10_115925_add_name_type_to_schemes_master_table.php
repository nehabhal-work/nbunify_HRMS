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
        Schema::table('schemes_master', function (Blueprint $table) {
            $table->string('name_type')->nullable()->after('scheme_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schemes_master', function (Blueprint $table) {
            $table->dropColumn('name_type');
        });
    }
};
