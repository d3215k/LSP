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
        Schema::create('hasil_umpan_balik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesmen_umpan_balik_id')->constrained('asesmen_umpan_balik')->cascadeOnDelete();
            $table->foreignId('komponen_umpan_balik_id')->constrained('komponen_umpan_balik')->cascadeOnDelete();
            $table->char('hasil', 1)->nullable();
            $table->string('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_umpan_balik');
    }
};
