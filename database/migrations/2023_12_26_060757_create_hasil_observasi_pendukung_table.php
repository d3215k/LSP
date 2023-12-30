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
        Schema::create('hasil_observasi_pendukung', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesmen_observasi_pendukung_id')->constrained('asesmen_observasi_pendukung')->cascadeOnDelete();
            $table->foreignId('pertanyaan_id')->constrained('pertanyaan_observasi_pendukung')->cascadeOnDelete();
            $table->char('kompeten', 2);
            $table->text('tanggapan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_observasi_pendukung');
    }
};
