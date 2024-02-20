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
        Schema::table('unit', function (Blueprint $table) {
            $table->integer('sort')->nullable();
        });

        Schema::table('elemen', function (Blueprint $table) {
            $table->integer('sort')->nullable();
        });

        Schema::table('kriteria_unjuk_kerja', function (Blueprint $table) {
            $table->integer('sort')->nullable();
        });

        Schema::table('pertanyaan_observasi_pendukung', function (Blueprint $table) {
            $table->integer('sort')->nullable();
        });

        Schema::table('pertanyaan_tertulis_esai', function (Blueprint $table) {
            $table->integer('sort')->nullable();
        });

        Schema::table('komponen_umpan_balik', function (Blueprint $table) {
            $table->integer('sort')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unit', function (Blueprint $table) {
            $table->dropColumn('sort');
        });

        Schema::table('elemen', function (Blueprint $table) {
            $table->dropColumn('sort');
        });

        Schema::table('kriteria_unjuk_kerja', function (Blueprint $table) {
            $table->dropColumn('sort');
        });

        Schema::table('pertanyaan_observasi_pendukung', function (Blueprint $table) {
            $table->dropColumn('sort');
        });

        Schema::table('pertanyaan_tertulis_esai', function (Blueprint $table) {
            $table->dropColumn('sort');
        });

        Schema::table('komponen_umpan_balik', function (Blueprint $table) {
            $table->dropColumn('sort');
        });
    }
};
