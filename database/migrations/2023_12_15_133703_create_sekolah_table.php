<?php

use App\Enums\SekolahType;
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
        Schema::create('sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedTinyInteger('type')->default(SekolahType::JEJARING);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('kompetensi_keahlian_sekolah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sekolah_id')->constrained('sekolah')->cascadeOnDelete();
            $table->foreignId('kompetensi_keahlian_id')->constrained('kompetensi_keahlian')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolah');
        Schema::dropIfExists('kompetensi_keahlian_sekolah');
    }
};
