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
        Schema::create('asesmen_persetujuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesmen_id')->constrained('asesmen')->cascadeOnDelete();
            $table->boolean('verifikasi_portofolio')->default(false);
            $table->boolean('observasi_langsung')->default(false);
            $table->boolean('hasil_tes_tulis')->default(false);
            $table->boolean('hasil_tes_lisan')->default(false);
            $table->boolean('hasil_wawancara')->default(false);
            $table->date('tanggal')->nullable();
            $table->foreignId('tuk_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesmen_persetujuan');
    }
};
