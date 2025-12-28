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
        Schema::create('account_vendors', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_code')->nullable();
            /* Client / Vendor Type */
            $table->enum('opt_client_vendor', ['client', 'vendor', 'both'])->default('client');

            /* Entity */
            $table->enum('entity_type', ['individual', 'non_individual']);
            $table->string('non_individual_type')->nullable();

            /* Tax */
            $table->enum('gst_mode', ['GST', 'Non-GST']);
            $table->string('gst_no', 15)->nullable();
            $table->string('pan', 10)->nullable();
            $table->string('tan_no', 10)->nullable();
            $table->string('vat_no', 12)->nullable();
            $table->string('cin', 25)->nullable();
            $table->string('aadhar_no', 15)->nullable();

            /* Client Classification */
            $table->enum('client_type', ['retainer', 'non-retainer'])->nullable();
            $table->string('under_head')->nullable();

            /* Financial */
            $table->decimal('service_charges', 12, 2)->nullable();

            /* Primary Details */
            $table->string('client_name', 100);
            $table->string('vendor_mobile', 10)->nullable();
            $table->string('vendor_email', 100)->nullable();

            /* Contact Person */
            $table->string('contact_person_name', 100);
            $table->string('contact_email', 100)->nullable();
            $table->string('contact_mobile', 10)->nullable();

            /* Address */
            $table->text('res_address')->nullable();
            $table->string('res_country')->nullable();
            $table->string('res_country_code')->nullable();
            $table->string('res_state')->nullable();
            $table->string('res_state_code')->nullable();
            $table->string('res_city')->nullable();
            $table->string('res_city_code')->nullable();
            $table->string('res_pincode', 6)->nullable();
            $table->string('remarks', 255)->nullable();

            // File Attachments
            $table->string('attachement_user_photo')->nullable();
            $table->string('attachment_pan')->nullable();
            $table->string('attachement_aadhar')->nullable();
            $table->string('attachment_gst')->nullable();
            $table->string('attachment_other_documents')->nullable();
            $table->string('attachment_cancelled_cheque')->nullable();

            //Bank Details
            $table->string('ifsc_code', 11)->nullable();;
            $table->string('account_number', 20)->nullable();;
            $table->string('bank_name')->nullable();;
            $table->string('branch_name')->nullable();;
            $table->string('bank_code')->nullable()->nullable();;

            /* Remarks */

            /* System */
            $table->boolean('is_active')->default(true);

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approved2_by')->nullable();
            $table->timestamp('approved2_on')->nullable();
            $table->unsignedBigInteger('approved3_by')->nullable();
            $table->timestamp('approved3_on')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_vendors');
    }
};
