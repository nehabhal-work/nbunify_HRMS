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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('head_office_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->references('id')->on('departments')->nullOnDelete();
            $table->string('name');
            $table->string('code', 50);
            $table->text('description')->nullable();
            $table->enum('dept_type', ['operational', 'support', 'admin']);
            $table->string('email')->nullable();
            $table->string('phone_ext', 20)->nullable();
            $table->string('head_name')->nullable();
            $table->string('head_email')->nullable();
            $table->decimal('budget', 15, 2)->nullable();
            $table->string('cost_centre', 50)->nullable();
            $table->integer('employee_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->json('meta')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['company_id', 'code']);
            $table->index(['company_id', 'branch_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
