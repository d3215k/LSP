<?php

use App\Enums\AsesmenTertulisStatus;
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
        Schema::create('asesmen_tertulis_pilihan_ganda', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesmen_id')->constrained('asesmen')->cascadeOnDelete();
            $table->date('tanggal_asesmen');
            $table->date('tanggal_periksa')->nullable();
            $table->unsignedTinyInteger('status')->default(AsesmenTertulisStatus::MULAI);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesmen_tertulis_pilihan_ganda');
    }
};
