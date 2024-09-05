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
            $table->string('monitor_chronicpain')->nullable();
            $table->string('monitor_chronicpain_location')->nullable();
            $table->string('monitor_chronicpain_scale')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('monitoring_histories', function (Blueprint $table) {
            //
            $table->dropColumn(['monitor_chronicpain','monitor_chronicpain_location','monitor_chronicpain_scale']);
        });
    }
};
