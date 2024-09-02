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
        Schema::table('monitoring_histories', function (Blueprint $table) {
            //
            $table->string('monitor_bloodpressure_measured')->nullable();
            $table->string('monitor_bloodpressure_measure_now')->nullable();
            $table->string('monitor_bloodpressure_systolic')->nullable();
            $table->string('monitor_bloodpressure_diastolic')->nullable();
            $table->string('monitor_bloodpressure_feeling')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monitoring_histories', function (Blueprint $table) {
            //
            $table->dropColumn(['monitor_bloodpressure_measured','monitor_bloodpressure_measure_now','monitor_bloodpressure_systolic','monitor_bloodpressure_diastolic','monitor_bloodpressure_feeling']);
        });
    }
};
