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
        Schema::create('investment_si', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investment_id');
            $table->string('si_number');
            $table->unsignedBigInteger('si_client_bank_id');
            $table->unsignedBigInteger('si_company_bank_id');
            $table->date('si_start_date');
            $table->decimal('si_amount', 15, 2);
            $table->unsignedInteger('si_no_of_payments');
            $table->string('attachment_si_image')->nullable();
            $table->string('attachment_notes_image')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('investment_id')->references('id')->on('investments')->onDelete('cascade');
            $table->foreign('si_client_bank_id')->references('id')->on('client_banks')->onDelete('cascade');
            $table->foreign('si_company_bank_id')->references('id')->on('company_bank_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_si');
    }
};
