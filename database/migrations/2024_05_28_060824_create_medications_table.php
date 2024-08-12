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
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->string('med_name');
            $table->string('med_id')->nullable();
            $table->string('med_form')->nullable();
            $table->string('med_form_look')->nullable();
            $table->string('med_pack_look')->nullable();
            $table->string('med_purpose')->nullable();
            $table->string('med_contraindications')->nullable();
            $table->string('med_sideeffects')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
