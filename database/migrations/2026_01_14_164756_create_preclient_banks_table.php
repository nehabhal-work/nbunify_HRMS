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
        Schema::create('preclient_banks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('preclient_id')->constrained('preclients')->onDelete('cascade');
            $table->string('ifsc_code', 11);
            $table->string('account_number', 20);
            $table->string('bank_name');
            $table->string('branch_name');
            $table->string('bank_code')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->index('preclient_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preclient_banks');
    }
};

