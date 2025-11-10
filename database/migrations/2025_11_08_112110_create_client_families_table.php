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
        Schema::create('client_families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');

            // Basic Information
            $table->string('name', 50);
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('dob')->nullable();
            $table->enum('live_status', ['alive', 'deceased'])->default('alive');
            $table->date('dod')->nullable();
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable();
            $table->enum('nationality', ['ri', 'nro', 'nre', 'pio', 'oci', 'gch', 'trioc', 'fn', 'other'])->nullable();
            $table->enum('occupation', ['private_sector', 'public_sector', 'government', 'business', 'eduation', 'professional', 'agriculture', 'student', 'doctor', 'housewife', 'retired', 'other'])->nullable();

            // Contact Information
            $table->string('mobile_no', 15)->nullable();
            $table->string('whatsapp_no', 15)->nullable();
            $table->string('landline_no', 15)->nullable();
            $table->string('email')->nullable();

            // Residential Address
            $table->text('res_address')->nullable();
            $table->string('res_country')->nullable();
            $table->string('res_state')->nullable();
            $table->string('res_city')->nullable();
            $table->string('res_pincode', 6)->nullable();

            // Office Address
            $table->text('office_address')->nullable();
            $table->string('office_country')->nullable();
            $table->string('office_state')->nullable();
            $table->string('office_city')->nullable();
            $table->string('office_pincode', 6)->nullable();

            // Relationship with client
            $table->foreignId('relation_id')->nullable()->constrained('family_relations')->onDelete('set null');
            $table->string('remarks', 100)->nullable();

            $table->timestamps();

            // Indexes
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_families');
    }
};
