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
        Schema::table('investments', function (Blueprint $table) {
            $table->dateTime('closing_letter_sent_at')->nullable()->after('welcome_letter_sent_at');
            $table->unsignedBigInteger('closing_letter_sent_by')->nullable()->after('closing_letter_sent_at');
            $table->string('closing_letter_sent_to')->nullable()->after('closing_letter_sent_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investments', function (Blueprint $table) {
            $table->dropColumn(['closing_letter_sent_at', 'closing_letter_sent_by', 'closing_letter_sent_to']);
        });
    }
};
