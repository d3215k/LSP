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
        Schema::create('jawaban_tertulis_pilihan_ganda', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesmen_tertulis_pilihan_ganda_id')->constrained('asesmen_tertulis_pilihan_ganda', 'id', 'jawaban_asesmen_pilihan_ganda')->cascadeOnDelete();
            $table->foreignId('pertanyaan_tertulis_pilihan_ganda_id')->constrained('pertanyaan_tertulis_pilihan_ganda', 'id', 'pertanyaan_asesmen_pilihan_ganda')->cascadeOnDelete();
            $table->foreignId('pilihan_jawaban_id')->nullable()->constrained('pilihan_jawaban')->nullOnDelete();
            $table->boolean('kompeten')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_tertulis_pilihan_ganda');
    }
};
