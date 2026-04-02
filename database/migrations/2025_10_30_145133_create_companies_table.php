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
            $table->string('name');
            $table->string('legal_name')->nullable();
            $table->enum('company_type', ['sole_proprietorship', 'partnership', 'pvt_ltd', 'public_ltd', 'llp', 'huf', 'ngo']);
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('logo')->nullable();

            $table->string('reg_address_line1')->nullable();
            $table->string('reg_address_line2')->nullable();
            $table->string('reg_city', 100)->nullable();
            $table->string('reg_state', 100)->nullable();
            $table->string('reg_country', 100)->nullable();
            $table->string('reg_pincode', 20)->nullable();

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

            // Attachments
            $table->string('attachment_pan')->nullable();
            $table->string('attachment_tan')->nullable();
            $table->string('attachment_gstin')->nullable();
            $table->string('attachment_ckyc')->nullable();
            $table->string('attachment_partnership_deed')->nullable();
            $table->string('attachment_udyam_aadhar')->nullable();
            $table->string('attachment_gumasta')->nullable();
            $table->string('attachment_msme')->nullable();

            $table->string('is_active')->default('active');

            $table->softDeletes();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->constrained('users')->onDelete('cascade');
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
