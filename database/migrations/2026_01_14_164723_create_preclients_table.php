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
        Schema::create('preclients', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('name', 50);
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('dob')->nullable();
            $table->enum('live_status', ['alive', 'deceased'])->default('alive');
            $table->date('dod')->nullable();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable();
            $table->enum('nationality', ['ri', 'nro', 'nre', 'pio', 'oci', 'gch', 'trioc', 'fn', 'other'])->nullable();
            $table->enum('occupation', ['private_sector', 'public_sector', 'government', 'business', 'eduation', 'professional', 'agriculture', 'student', 'doctor', 'housewife', 'retired', 'other'])->nullable();

            // Identity Documents
            $table->string('pan_no', 10)->nullable();
            $table->string('aadhar_no', 12)->nullable();
            $table->string('ckyc_no', 14)->nullable();

            // Contact Information
            $table->string('mobile_no', 15)->nullable();
            $table->string('whatsapp_no', 15)->nullable();
            $table->string('landline_no', 15)->nullable();
            $table->string('email')->nullable();

            // Residential Address
            $table->text('res_address')->nullable();
            $table->string('res_country')->nullable();
            $table->string('res_country_code')->nullable();
            $table->string('res_state')->nullable();
            $table->string('res_state_code')->nullable();
            $table->string('res_city')->nullable();
            $table->string('res_city_code')->nullable();
            $table->string('res_pincode', 6)->nullable();

            // Office Address
            $table->text('office_address')->nullable();
            $table->string('office_country')->nullable();
            $table->string('office_country_code')->nullable();
            $table->string('office_state')->nullable();
            $table->string('office_state_code')->nullable();
            $table->string('office_city')->nullable();
            $table->string('office_city_code')->nullable();
            $table->string('office_pincode', 6)->nullable();

            // Additional Information
            $table->unsignedBigInteger('relation_manager_id')->nullable();
            $table->string('remarks', 100)->nullable();

            // File Attachments
            $table->string('attachment_client_photo')->nullable();
            $table->string('attachment_pan')->nullable();
            $table->string('attachment_aadhar_front')->nullable();
            $table->string('attachment_aadhar_back')->nullable();
            $table->string('attachment_signature')->nullable();
            $table->string('attachment_ckyc')->nullable();
            $table->string('attachment_other_documents')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('name');
            $table->index('pan_no');
            $table->index('aadhar_no');
            $table->index('mobile_no');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preclients');
    }
};

