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
        Schema::dropIfExists('investment_payment_schedules');
        Schema::dropIfExists('investment_si');
        Schema::dropIfExists('investments');

        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->date('investment_date');
            $table->string('investment_type');
            $table->unsignedBigInteger('first_client_id');
            $table->unsignedBigInteger('second_client_id')->nullable();
            $table->unsignedBigInteger('third_client_id')->nullable();
            $table->unsignedBigInteger('fourth_client_id')->nullable();
            $table->unsignedBigInteger('scheme_id');
            $table->decimal('investment_amount', 15, 2);
            $table->string('tenure_type');
            $table->integer('tenure_count');
            $table->string('frequency');
            $table->decimal('roi_percent', 5, 2);
            $table->decimal('additional_roi_percent', 5, 2)->nullable();
            $table->boolean('has_tds')->default(false);
            $table->string('attachment_tds')->nullable();
            $table->unsignedBigInteger('from_company_bank_id');
            $table->unsignedBigInteger('to_client_bank_id');

            $table->unsignedInteger('schedule_count');
            $table->decimal('annual_payout',15,2);
            $table->decimal('payout_per_period',15,2);
            $table->date('maturity_date');
            $table->date('first_payout_date');
            $table->decimal('actual_interest_amount',15,2);
            $table->decimal('paid_interest_amount',15,2);
            $table->decimal('rounding_off_amount', 15,2);

            $table->timestamps();

            $table->foreign('first_client_id')->references('id')->on('clients');
            $table->foreign('second_client_id')->references('id')->on('clients');
            $table->foreign('third_client_id')->references('id')->on('clients');
            $table->foreign('fourth_client_id')->references('id')->on('clients');

            $table->foreign('from_company_bank_id')->references('id')->on('company_bank_details');
            $table->foreign('to_client_bank_id')->references('id')->on('client_banks');

            $table->foreign('scheme_id')->references('id')->on('schemes_master');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
