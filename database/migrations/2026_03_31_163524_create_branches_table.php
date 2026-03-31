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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('head_office_id')->constrained('head_offices')->cascadeOnDelete();
            $table->string('name');
            $table->string('code', 50);
            $table->enum('branch_type', ['regional', 'local', 'satellite'])->default('local');
            $table->string('email');
            $table->string('phone', 20)->nullable();
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('city', 100);
            $table->string('state', 100);
            $table->string('country', 100);
            $table->string('postal_code', 20)->nullable();
            $table->string('manager_name')->nullable();
            $table->string('manager_email')->nullable();
            $table->json('opening_hours')->nullable();
            $table->integer('employee_count')->default(0);
            $table->enum('status', ['active', 'inactive', 'closed'])->default('active');
            $table->integer('sort_order')->default(0);
            $table->json('meta')->nullable();
            $table->softDeletes();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['company_id', 'code']);
            $table->index(['company_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
