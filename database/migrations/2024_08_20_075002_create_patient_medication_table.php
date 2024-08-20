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
            $table->unsignedBigInteger('patient_id'); // Foreign key to patients table
            $table->string('medication');
            $table->string('purpose_of_medication');
            $table->text('use_schedule'); // Can be JSON or TEXT based on your requirement
            $table->string('food_use');
            $table->string('dose_use');
            $table->string('doses_per_package');
            $table->date('last_prescription_start');
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
