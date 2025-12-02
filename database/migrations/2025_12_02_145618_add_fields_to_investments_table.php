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
        Schema::table('investments', function (Blueprint $table) {
            // New fields not in original table
            $table->unsignedBigInteger('client_bank_id');
            $table->unsignedBigInteger('company_bank_id');
            $table->string('reference_no');
            $table->text('remarks')->nullable();
            $table->enum('instrument_type', ['neft', 'rtgs', 'imps', 'upi', 'cheque', 'cash', 'dd']);
            $table->enum('status', ['active', 'merged', 'matured', 'cancelled', 'renewed'])->default('active');
            $table->date('instrument_date');
            $table->string('attachment_instrument_image')->nullable();
            $table->date('effective_credit_date');

            // Additional calculation fields
            $table->decimal('annual_payout', 15, 2);
            $table->decimal('payout_per_period', 15, 2);
            $table->integer('schedule_count');
            $table->timestamp('first_payout_date')->nullable();
            $table->decimal('actual_interest_amount', 15, 2);
            $table->decimal('paid_interest_amount', 15, 2)->default(0);
            $table->decimal('rounding_off_amount', 10, 2)->default(0);

            // Foreign key constraints
            $table->foreign('client_bank_id')->references('id')->on('client_banks')->onDelete('cascade');
            $table->foreign('company_bank_id')->references('id')->on('company_bank_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
