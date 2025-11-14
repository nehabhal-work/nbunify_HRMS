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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('brand_name', 50)->nullable(true);
            $table->string('proprietor_name', 50)->nullable(true);
            $table->string('proprietor_phone', 20)->nullable(true);
            $table->string('proprietor_email', 20)->nullable(true);
            $table->string('proprietor_whatsapp', 20)->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('brand_name', 50);
            $table->dropColumn('proprietor_name', 20);
            $table->dropColumn('proprietor_phone', 20);
            $table->dropColumn('proprietor_email', 20);
            $table->dropColumn('proprietor_whatsapp', 20);
        });
    }
};
