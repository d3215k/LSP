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
        Schema::create('asesi', function (Blueprint $table) {
            $table->id();
            $table->string('no_identitas')->nullable();
            $table->string('nama');
            $table->char('jk', 1)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('alamat_rumah')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('no_telepon_rumah')->nullable();
            $table->string('no_telepon_hp')->nullable();
            $table->string('email')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesi');
    }
};
