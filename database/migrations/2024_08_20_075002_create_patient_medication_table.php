<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patient_medication', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable(); // Foreign key to patients table
            $table->string('medication')->nullable();
            $table->string('purpose_of_medication')->nullable();
            $table->text('use_schedule')->nullable(); // Can be JSON or TEXT based on your requirement
            $table->string('food_use')->nullable();
            $table->string('dose_use')->nullable();
            $table->string('doses_per_package')->nullable();
            $table->date('last_prescription_start')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_medication');
    }
};
