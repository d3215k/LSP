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
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesmen_id')->nullable()->constrained('asesmen')->nullOnDelete();
            $table->string('no_sertifikat');
            $table->string('no_blanko')->nullable();
            $table->string('pemilik');
            $table->string('bidang')->nullable();
            $table->string('kompetensi')->nullable();
            $table->json('unit')->nullable();
            $table->string('tempat_terbit')->nullable();
            $table->date('tanggal_terbit')->nullable();
            $table->string('masa_berlaku')->nullable();
            $table->string('masa_berlaku_en')->nullable();
            $table->string('ketua_lsp')->nullable();
            $table->string('ketua_bidang_sertifikasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikat');
    }
};
