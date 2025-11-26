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
        Schema::table('client_banks', function (Blueprint $table) {
            $table->string('operation_mode')->nullable()->after('attachment_cancelled_cheque');
            $table->string('holder_name_1')->nullable()->after('operation_mode');
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
        Schema::table('client_banks', function (Blueprint $table) {
            $table->dropColumn([
                'operation_mode_string',
                'holder_name_1',
                'holder_name_2',
                'holder_name_3',
                'micrcode'
            ]);
        });
    }
};
