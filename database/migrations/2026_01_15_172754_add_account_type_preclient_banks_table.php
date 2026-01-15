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
        Schema::table('preclient_banks', function (Blueprint $table) {
            $table->string('account_type', 20)->nullable()->after('is_primary');
            $table->string('attachment_cancelled_cheque')->nullable()->after('account_type');
            $table->string('operation_mode', 20)->nullable()->after('attachment_cancelled_cheque');
            $table->string('holder_name_1', 50)->nullable()->after('operation_mode');
            $table->string('holder_name_2')->nullable()->after('holder_name_1');
            $table->string('holder_name_3')->nullable()->after('holder_name_2');
            $table->string('micrcode', 9)->nullable()->after('holder_name_3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('preclient_banks', function (Blueprint $table) {
            $table->dropColumn([
                'account_type',
                'operation_mode',
                'holder_name_1',
                'holder_name_2',
                'holder_name_3',
                'micrcode'
            ]);
        });
    }
};
