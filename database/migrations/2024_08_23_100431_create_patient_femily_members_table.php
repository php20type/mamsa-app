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
        Schema::create('patient_femily_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('relation')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_femily_members');
    }
};
