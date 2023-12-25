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
        Schema::create('rincian_data_pemohon', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesmen_id')->constrained('asesmen')->cascadeOnDelete();
            $table->string('nama');
            $table->string('no_identitas')->nullable();
            $table->char('jk', 1)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('kebangsaan')->nullable();
            $table->string('alamat_rumah')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('no_telepon_rumah')->nullable();
            $table->string('no_telepon_hp')->nullable();
            $table->string('kualifikasi_pendidikan')->nullable();
            $table->string('nama_institusi')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('alamat_kantor')->nullable();
            $table->string('kode_pos_kantor')->nullable();
            $table->string('no_telepon_kantor')->nullable();
            $table->string('no_fax_kantor')->nullable();
            $table->string('email_kantor')->nullable();
            $table->date('tanggal_registrasi')->nullable();
            $table->string('ttd')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincian_data_pemohon');
    }
};
