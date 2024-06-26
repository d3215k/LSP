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
        Schema::create('pertanyaan_tertulis_pilihan_ganda', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('unit')->cascadeOnDelete();
            $table->text('pertanyaan');
            $table->boolean('aktif')->default(true);
            $table->integer('sort')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_tertulis_pilihan_ganda');
    }
};
