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
        Schema::create('investment_payout_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('investment_id');

            $table->date('sch_payout_date');
            $table->decimal('sch_payout_amount',15,2);
            $table->date('actual_payout_date')->nullable();
            $table->enum('status',['pending','done'])->default('pending');
            $table->string('remarks')->nullable();
            $table->decimal('actual_payout_amount',15,2)->nullable();
            $table->string('utr_no')->nullable();
            $table->unsignedBigInteger('from_company_bank_id');
            $table->unsignedBigInteger('to_client_bank_id');


            $table->foreign('investment_id')->references('id')->on('investments')->onDelete('cascade');
            $table->foreign('to_client_bank_id')->references('id')->on('client_banks')->onDelete('cascade');
            $table->foreign('from_company_bank_id')->references('id')->on('company_bank_details')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_payout_schedules');
    }
};
