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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('financial_year', 10);
            $table->unsignedBigInteger('customer_id');
            $table->string('invoice_no', 20);
            $table->date('bill_date');
            $table->decimal('total_quantity', 15, 2)->default(0);
            $table->decimal('total_bill_amount', 15, 2)->default(0);
            $table->decimal('total_tds_percent', 15, 2)->default(0);
            $table->decimal('total_tds_amount', 15, 2)->default(0);
            $table->decimal('total_gst_percent', 15, 2)->default(0);
            $table->decimal('total_gst_amount', 15, 2)->default(0);
            $table->decimal('total_net_amount', 15, 2)->default(0);
            $table->string('attachment_invoice')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->index(['financial_year', 'customer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
