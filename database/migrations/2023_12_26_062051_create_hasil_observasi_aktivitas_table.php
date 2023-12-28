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
        Schema::create('hasil_observasi_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesmen_observasi_aktivitas_id')->constrained('asesmen_observasi_aktivitas')->cascadeOnDelete();
            $table->foreignId('kriteria_unjuk_kerja_id')->constrained('kriteria_unjuk_kerja')->cascadeOnDelete();
            $table->char('kompeten', 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_observasi_aktivitas');
    }
};
