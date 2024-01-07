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
        Schema::create('jawaban_tertulis_esai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesmen_tertulis_esai_id')->constrained('asesmen_tertulis_esai')->cascadeOnDelete();
            $table->foreignId('pertanyaan_tertulis_esai_id')->constrained('pertanyaan_tertulis_esai')->cascadeOnDelete();
            $table->longText('jawaban')->nullable();
            $table->char('kompeten', 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_tertulis_esai');
    }
};
