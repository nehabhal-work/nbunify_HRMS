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
        Schema::table('investment_input_banks', function (Blueprint $table) {
            $table->string('attachment_instrument')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investment_input_banks', function (Blueprint $table) {
            $table->string('attachment_instrument')->nullable(false)->change();
        });
    }
};
