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
        Schema::create('jawaban_mandiri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesmen_mandiri_id')->constrained('asesmen_mandiri')->cascadeOnDelete();
            $table->foreignId('elemen_id')->constrained('elemen')->cascadeOnDelete();
            $table->char('kompeten', 2)->nullable();
            $table->foreignId('bukti_asesmen_mandiri_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_mandiri');
    }
};
