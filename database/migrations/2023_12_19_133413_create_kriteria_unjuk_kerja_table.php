<?php

use App\Models\Elemen;
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
        Schema::create('kriteria_unjuk_kerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('elemen_id')->constrained('elemen', 'id')->cascadeOnDelete();
            $table->string('nama');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria_unjuk_kerja');
    }
};
