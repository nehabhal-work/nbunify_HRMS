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
        Schema::create('schemes_master', function (Blueprint $table) {
            $table->id();
            // Basic Fields
            $table->date('start_date');
            $table->date('end_date');

            $table->string('scheme_name', 100);

            // ROI Fields
            $table->decimal('roi_min', 5, 2)->nullable();
            $table->decimal('roi_max', 5, 2)->nullable();
            $table->decimal('roi_additional', 5, 2)->nullable();

            // Tenure Fields
            $table->enum('tenure_type', ['days', 'months', 'years']);
            $table->integer('tenure_min')->nullable();
            $table->integer('tenure_max')->nullable();

            // Payout frequencies (multiple)
            $table->json('frequency')->nullable();     // MULTIPLE VALUES
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schemes_master');
    }
};
