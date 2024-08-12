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
        Schema::create('monitoring_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('doctor_id')->nullable();
            $table->integer('patient_id')->nullable();
            $table->integer('monitor_id')->nullable();
            $table->dateTime('rep_date')->nullable();
            $table->string('rep_overall')->nullable();
            $table->string('rep_overall_neg')->nullable();
            $table->string('rep_overall_bodypart')->nullable();
            $table->string('rep_monitor_condition')->nullable();
            $table->string('rep_monitor_condition_neg')->nullable();
            $table->string('rep_medication')->nullable();
            $table->string('rep_medication_neg')->nullable();
            $table->string('rep_medication_sideeffect')->nullable();
            $table->string('rep_medication_bodypart')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_histories');
    }
};
