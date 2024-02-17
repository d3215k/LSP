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
        Schema::create('asesor_skema', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesor_id')->constrained('asesor')->cascadeOnDelete();
            $table->foreignId('skema_id')->constrained('skema')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesor_skema');
    }
};
