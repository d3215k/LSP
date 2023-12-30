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
        Schema::create('hasil_rekaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesmen_rekaman_id')->constrained('asesmen_rekaman')->cascadeOnDelete();
            $table->foreignId('unit_id')->constrained('unit')->cascadeOnDelete();
            $table->boolean('obervasi_demonstrasi')->default(false);
            $table->boolean('portofolio')->default(false);
            $table->boolean('pernyataan_pihak_ketiga_pertanyaan_wawancara')->default(false);
            $table->boolean('pertanyaan_lisan')->default(false);
            $table->boolean('pertanyaan_tertulis')->default(false);
            $table->boolean('proyek_kerja')->default(false);
            $table->boolean('lainnya')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_rekaman');
    }
};
