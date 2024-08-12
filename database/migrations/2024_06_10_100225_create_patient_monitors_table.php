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
        Schema::create('patient_monitors', function (Blueprint $table) {
            $table->id();
            $table->integer('doctor_id')->nullable();
            $table->integer('patient_id')->nullable();
            $table->string('monitor_condition')->nullable();
            $table->string('medication')->nullable();
            $table->string('dose')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_monitors');
    }
};
