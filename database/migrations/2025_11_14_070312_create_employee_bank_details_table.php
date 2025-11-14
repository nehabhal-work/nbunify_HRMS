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
        Schema::create('employee_bank_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->string('account_number', 20);
            $table->string('ifsc_code', 11);
            $table->string('bank_name');
            $table->string('branch_name');
            $table->string('bank_code', 4)->nullable();
            $table->enum('account_type', ['savings', 'current', 'od_cc', 'nre', 'nri', 'nro', 'tem_deposit', 'ra'])->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->index('employee_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_bank_details');
    }
};
