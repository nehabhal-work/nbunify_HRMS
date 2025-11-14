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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('name', 100);
            $table->enum('gender', ['male', 'female','other'])->nullable();
            $table->date('dob')->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('email')->nullable();
            $table->string('aadhar', 12)->nullable();
            $table->string('pan', 10)->nullable();

            // Local Address
            $table->text('registered_address')->nullable();
            $table->string('registered_state')->nullable();
            $table->string('registered_city')->nullable();
            $table->string('registered_pincode', 6)->nullable();

            // Permanent Address
            $table->text('corporate_address')->nullable();
            $table->string('corporate_state')->nullable();
            $table->string('corporate_city')->nullable();
            $table->string('corporate_pincode', 6)->nullable();

            // Work Information
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('deptment_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->date('joining_date')->nullable();
            $table->integer('probation_date')->nullable();
            $table->integer('notice_date')->nullable();
            $table->enum('status', ['contract', 'permanent', 'probation', 'intern'])->default('contract');
            $table->unsignedBigInteger('reporting_manager')->nullable();
            $table->string('role')->nullable();

            // Salary Information
            $table->decimal('basic_salary', 10, 2)->nullable();
            $table->decimal('hra', 10, 2)->nullable();
            $table->decimal('travel_allowance', 10, 2)->nullable();
            $table->decimal('conveyance_allowance', 10, 2)->nullable();
            $table->decimal('medical_allowance', 10, 2)->nullable();
            $table->decimal('bonus', 10, 2)->nullable();
            $table->decimal('other_allowances', 10, 2)->nullable();

            // Attachments
            $table->string('attachement_employee_photo')->nullable();
            $table->string('attachement_aadhar')->nullable();
            $table->string('attachment_release_letter')->nullable();
            $table->string('attachment_expereance')->nullable();
            $table->string('attachment_pan')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('name');
            $table->index('email');
            $table->index('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
