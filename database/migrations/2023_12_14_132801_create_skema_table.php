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
        Schema::create('skema', function (Blueprint $table) {
            $table->id();
            // $table->string('mode');
            $table->string('nama');
            $table->string('jenis');
            $table->string('kode');
            // $table->date('tanggal_penetapan')->nullable();
            $table->string('no_urut')->nullable();
            // $table->string('no_penetapan')->nullable();
            // $table->unsignedInteger('biaya_assesmen')->nullable();
            $table->string('kompetensi_keahlian')->nullable();
            $table->string('kompetensi_keahlian_en')->nullable();
            $table->string('level_kkni')->nullable();
            $table->string('bidang')->nullable();
            $table->string('bidang_en')->nullable();
            // $table->string('sub_sektor')->nullable();
            // $table->string('sub_bidang')->nullable();
            // $table->string('sub_bidang_mea')->nullable();
            // $table->string('kbji')->nullable();
            // $table->string('sub_kbji')->nullable();
            // $table->string('sub_bidang_kbji')->nullable();
            $table->string('file')->nullable();
            $table->string('cover')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skema');
    }
};
