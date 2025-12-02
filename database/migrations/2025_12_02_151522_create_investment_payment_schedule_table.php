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
        Schema::create('investment_payment_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investment_id');
            $table->date('payout_date');
            $table->decimal('amount', 15, 2);
            $table->date('actual_payout_date')->nullable();
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->text('remarks')->nullable();
            $table->decimal('actual_payout_amount', 15, 2)->default(0);
            $table->string('reference_no')->nullable();
            $table->unsignedBigInteger('company_bank_id')->nullable();
            $table->unsignedBigInteger('client_bank_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('investment_id')->references('id')->on('investments')->onDelete('cascade');
            $table->foreign('company_bank_id')->references('id')->on('company_bank_details')->onDelete('set null');
            $table->foreign('client_bank_id')->references('id')->on('client_banks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_payment_schedules');
    }
};
