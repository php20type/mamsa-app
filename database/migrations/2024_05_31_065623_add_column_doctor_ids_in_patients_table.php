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
        Schema::table('patients', function (Blueprint $table) {
            //
            $table->string('doctor_ids')->nullable();
            $table->string('facility_ids')->nullable();
            $table->string('frequency')->nullable();
            $table->time('preferred_time_from')->nullable();
            $table->time('preferred_time_to')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            //
            $table->dropColumn(['doctor_ids','facility_ids','frequency','preferred_time_from','preferred_time_to']);
        });
    }
};
