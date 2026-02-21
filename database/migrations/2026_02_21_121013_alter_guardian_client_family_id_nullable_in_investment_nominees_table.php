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
        Schema::table('investment_nominees', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['guardian_client_family_id']);

            // Make column nullable
            $table->unsignedBigInteger('guardian_client_family_id')
                ->nullable()
                ->change();

            // Re-add foreign key
            $table->foreign('guardian_client_family_id')
                ->references('id')
                ->on('client_families')
                ->nullOnDelete(); // optional & recommended
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investment_nominees', function (Blueprint $table) {
            $table->dropForeign(['guardian_client_family_id']);

            $table->unsignedBigInteger('guardian_client_family_id')
                ->nullable(false)
                ->change();

            $table->foreign('guardian_client_family_id')
                ->references('id')
                ->on('client_families');
        });
    }
};
