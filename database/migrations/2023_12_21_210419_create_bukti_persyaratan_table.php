<?php

use App\Enums\BuktiPersyaratanStatus;
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
        Schema::create('bukti_persyaratan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesmen_id')->constrained('asesmen')->cascadeOnDelete();
            $table->foreignId('persyaratan_id')->constrained('persyaratan')->cascadeOnDelete();
            $table->string('nama');
            $table->string('file');
            $table->unsignedTinyInteger('status')->default(BuktiPersyaratanStatus::ADA);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukti_persyaratan');
    }
};
