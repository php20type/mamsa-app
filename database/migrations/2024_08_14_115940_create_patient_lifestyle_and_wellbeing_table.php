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
        Schema::create('patient_lifestyle_and_wellbeing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('regular_food_intake')->nullable();
            $table->integer('hydration')->nullable(); // Amount in milliliters or similar
            $table->decimal('qxy_gometer', 5, 2)->nullable(); // Adjust as needed
            $table->string('quality_of_sleep')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_lifestyle_and_wellbeing');
    }
};
