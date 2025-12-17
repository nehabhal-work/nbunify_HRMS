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
        Schema::create('investment_input_banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investment_id');
            $table->unsignedBigInteger('from_client_bank_id');
            $table->unsignedBigInteger('to_company_bank_id');
            $table->string('instrument_type');
            $table->date('client_instrument_date');
            $table->string('client_reference_no')->nullable();
            $table->decimal('amount',15,2);
            $table->string('attachment_instrument');
            $table->string('company_reference_no')->nullable();
            $table->date('company_instrument_date');
            
            $table->foreign('investment_id')->references('id')->on('investments')->onDelete('cascade');
            $table->foreign('from_client_bank_id')->references('id')->on('client_banks');
            $table->foreign('to_company_bank_id')->references('id')->on('company_bank_details');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_input_banks');
    }
};
