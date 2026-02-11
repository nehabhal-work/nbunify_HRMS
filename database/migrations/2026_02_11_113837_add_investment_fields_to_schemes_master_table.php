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
            $table->enum('investment_type', ['single', 'joined'])->default('single')->after('name_type');
            $table->decimal('min_investment', 15, 2)->nullable()->after('investment_type');
            $table->decimal('max_investment', 15, 2)->nullable()->after('min_investment');
            $table->decimal('investment_denomination', 15, 2)->nullable()->after('max_investment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schemes_master', function (Blueprint $table) {
            $table->dropColumn(['investment_type', 'min_investment', 'max_investment', 'investment_denomination']);
        });
    }
};
