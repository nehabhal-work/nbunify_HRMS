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
        Schema::create('investment_nominees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investment_id');
            $table->unsignedBigInteger('client_family_id');
            $table->unsignedBigInteger('guardian_client_family_id');
            $table->decimal('percent',5,2);

            $table->foreign('investment_id')->references('id')->on('investments')->onDelete('cascade');
            $table->foreign('client_family_id')->references('id')->on('client_families');
            $table->foreign('guardian_client_family_id')->references('id')->on('client_families');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_nominees');
    }
};
