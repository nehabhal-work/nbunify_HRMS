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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            // Basic Company Information
            $table->string('logo')->nullable();
            $table->string('name');
            $table->enum('company_type', ['sole_proprietorship', 'partnership', 'pvt_ltd', 'public_ltd', 'llp', 'huf', 'ngo']);
            $table->string('domain')->nullable();

            // Registration Numbers
            $table->string('watermark_no')->nullable();
            $table->string('copyrights_no')->nullable();
            $table->string('cin_no')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('tan_no')->nullable();
            $table->string('gstin')->nullable();
            $table->string('udyam_aadhar_no')->nullable();
            $table->string('partnership_registration_no')->nullable();
            $table->string('roc_no')->nullable();
            $table->string('msme_certification_no')->nullable();
            $table->string('ckyc')->nullable();
            $table->string('gumasta_no')->nullable();

            // Establishment Date
            $table->date('est_date')->nullable();

            // Registered Address
            $table->text('registered_address')->nullable();
            $table->string('registered_country')->nullable();
            $table->string('registered_state')->nullable();
            $table->string('registered_city')->nullable();
            $table->string('registered_pincode')->nullable();

            // Corporate Address
            $table->text('corporate_address')->nullable();
            $table->string('corporate_country')->nullable();
            $table->string('corporate_state')->nullable();
            $table->string('corporate_city')->nullable();
            $table->string('corporate_pincode')->nullable();

            // Additional Address
            $table->text('additional_address')->nullable();
            $table->string('additional_country')->nullable();
            $table->string('additional_state')->nullable();
            $table->string('additional_city')->nullable();
            $table->string('additional_pincode')->nullable();

            // Contact Information
            $table->string('contact_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            // Attachments
            $table->string('attachment_pan')->nullable();
            $table->string('attachment_tan')->nullable();
            $table->string('attachment_gstin')->nullable();
            $table->string('attachment_ckyc')->nullable();
            $table->string('attachment_partnership_deed')->nullable();
            $table->string('attachment_udyam_aadhar')->nullable();
            $table->string('attachment_gumasta')->nullable();
            $table->string('attachment_msme')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
