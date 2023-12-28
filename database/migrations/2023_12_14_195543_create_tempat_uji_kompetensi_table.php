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
        Schema::create('tempat_uji_kompetensi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jenis');
            $table->string('kode');
            $table->string('provinsi');
            $table->string('kota_kabupaten');
            $table->string('alamat');
            $table->string('koordinat_lokasi');
            $table->string('no_telp');
            $table->string('no_hp');
            $table->string('no_fax');
            $table->string('email');
            $table->timestamps();
        });

        Schema::create('skema_tempat_uji_kompetensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skema_id')->constrained('skema')->cascadeOnDelete();
            $table->foreignId('tempat_uji_kompetensi_id')->constrained('tempat_uji_kompetensi')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skema_tempat_uji_kompetensi');
        Schema::dropIfExists('tempat_uji_kompetensi');
    }
};
