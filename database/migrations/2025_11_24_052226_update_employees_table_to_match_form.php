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
        Schema::table('employees', function (Blueprint $table) {
            // Remove corporate address fields (not in form)
            $table->dropColumn([
                'corporate_address',
                'corporate_state',
                'corporate_city',
                'corporate_pincode'
            ]);

            // Rename registered address fields to match form
            $table->renameColumn('registered_address', 'res_address');
            $table->renameColumn('registered_state', 'res_state');
            $table->renameColumn('registered_city', 'res_city');
            $table->renameColumn('registered_pincode', 'res_pincode');

            // Add new fields from form
            $table->string('res_country_code', 3)->nullable()->after('res_pincode');
            $table->string('res_state_code', 3)->nullable()->after('res_country_code');
            $table->string('res_city_code', 10)->nullable()->after('res_state_code');
            $table->decimal('prev_salary', 10, 2)->nullable()->after('other_allowances');
            $table->string('attachment_cv')->nullable()->after('attachment_pan');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Reverse the changes
            $table->dropColumn([
                'res_country_code',
                'res_state_code',
                'res_city_code',
                'prev_salary',
                'attachment_cv'
            ]);

            // Rename back to original names
            $table->renameColumn('res_address', 'registered_address');
            $table->renameColumn('res_state', 'registered_state');
            $table->renameColumn('res_city', 'registered_city');
            $table->renameColumn('res_pincode', 'registered_pincode');

            // Add back corporate address fields
            $table->text('corporate_address')->nullable();
            $table->string('corporate_state')->nullable();
            $table->string('corporate_city')->nullable();
            $table->string('corporate_pincode', 6)->nullable();
        });
    }
};
