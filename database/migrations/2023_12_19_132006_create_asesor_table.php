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
        Schema::create('asesor', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_registrasi');
            $table->string('nama');
            $table->char('nik', 32)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->char('jk', 1)->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('alamat_ktp_provinsi')->nullable();
            $table->string('alamat_ktp_kota_kabupaten')->nullable();
            $table->string('alamat_ktp_lengkap')->nullable();
            $table->string('alamat_tempat_tinggal_status')->nullable();
            $table->string('alamat_tempat_tinggal_provinsi')->nullable();
            $table->string('alamat_tempat_tinggal_kota_kabupaten')->nullable();
            $table->string('alamat_tempat_tinggal_lengkap')->nullable();
            $table->string('email')->unique();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesor');
    }
};
