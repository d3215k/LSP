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
        Schema::create('asesmen_mandiri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesmen_id')->constrained('asesmen')->cascadeOnDelete();
            $table->date('tanggal_asesmen_mandiri')->nullable();
            $table->date('tanggal_ditinjau')->nullable();
            $table->unsignedTinyInteger('rekomendasi')->nullable();
            $table->string('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesmen_mandiri');
    }
};
