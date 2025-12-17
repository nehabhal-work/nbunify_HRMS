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
            $table->enum('status',['open','closed'])->default('open');
            $table->enum('action_status',['new','renewed','matured','merged','claimed','withdraw'])->default('new');
            $table->decimal('exit_load_percent',5,2)->nullable();
            $table->integer('lock_in_period')->default(0);
            $table->string('lock_in_period_type')->default('years');
            $table->unsignedBigInteger('created_by')->nullable()->after('updated_at');
            $table->unsignedBigInteger('approved_by')->nullable()->after('created_by');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->unsignedBigInteger('approved2_by')->nullable();
            $table->timestamp('approved2_on')->nullable();
            $table->unsignedBigInteger('approved3_by')->nullable();
            $table->timestamp('approved3_on')->nullable();
        });

        Schema::table('schemes_master', function (Blueprint $table) {
            $table->decimal('exit_load_percent',5,2)->nullable();
            $table->integer('lock_in_period')->default(0);
            $table->string('lock_in_period_type')->default('years');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investments', function (Blueprint $table) {
            $table->dropColumn([
                'status', 'action_status', 'exit_load_percent', 'lock_in_period', 
                'lock_in_period_type', 'created_by', 'approved_by', 'approved_at',
                'approved2_by', 'approved2_on', 'approved3_by', 'approved3_on'
            ]);
        });

        Schema::table('schemes_master', function (Blueprint $table) {
            $table->dropColumn(['exit_load_percent', 'lock_in_period', 'lock_in_period_type']);
        });
    }
};
