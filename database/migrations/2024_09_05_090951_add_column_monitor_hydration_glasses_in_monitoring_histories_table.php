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
            $table->string('monitor_hydration_glasses')->nullable();
            $table->string('monitor_hydration_level')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monitoring_histories', function (Blueprint $table) {
            //
            $table->dropColumn(['monitor_hydration_glasses','monitor_hydration_level']);
        });
    }
};
