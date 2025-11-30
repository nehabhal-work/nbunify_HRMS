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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->date('investment_date');
            $table->string('investment_type');
            $table->unsignedBigInteger('client_id');
            $table->json('other_holders')->nullable();
            $table->unsignedBigInteger('scheme_id');
            $table->decimal('investment_amount', 15, 2);
            $table->string('tenure_type');
            $table->integer('tenure_count');
            $table->string('frequency');
            $table->decimal('roi_percent', 5, 2);
            $table->decimal('additional_roi_percent', 5, 2)->nullable();
            $table->date('maturity_date');
            $table->decimal('payout_amount', 15, 2);
            $table->boolean('has_tds')->default(false);
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
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
