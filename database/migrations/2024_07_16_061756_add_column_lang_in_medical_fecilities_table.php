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
        Schema::table('medical_fecilities', function (Blueprint $table) {
            //
            $table->string('lang')->default('en')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_fecilities', function (Blueprint $table) {
            //
            $table->dropColumn('lang');
        });
    }
};
