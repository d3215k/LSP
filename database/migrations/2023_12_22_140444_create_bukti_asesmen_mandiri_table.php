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
        Schema::create('bukti_asesmen_mandiri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesmen_id')->constrained('asesmen')->cascadeOnDelete();
            $table->string('nama');
            $table->string('deskripsi')->nullable();
            $table->string('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_asesmen_mandiri');
    }
};
