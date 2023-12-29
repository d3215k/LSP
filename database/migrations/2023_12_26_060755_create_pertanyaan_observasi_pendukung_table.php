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
        Schema::create('pertanyaan_observasi_pendukung', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesmen_observasi_id')->constrained('asesmen_observasi_pendukung')->cascadeOnDelete();
            $table->foreignId('unit_id')->constrained('unit')->cascadeOnDelete();
            $table->text('pertanyaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_observasi_pendukung');
    }
};