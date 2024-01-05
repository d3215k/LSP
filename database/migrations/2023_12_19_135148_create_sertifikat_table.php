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
            $table->string('jenis');
            $table->string('pemilik');
            $table->string('no_reg');
            $table->string('no_sertifikat');
            $table->string('no_blanko')->nullable();
            $table->string('bidang')->nullable();
            $table->string('bidang_en')->nullable();
            $table->string('prefix_kompetensi')->nullable();
            $table->string('kompetensi')->nullable();
            $table->string('kompetensi_en')->nullable();
            $table->json('unit')->nullable();
            $table->date('tanggal_terbit')->nullable();
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
