<?php

use App\Enums\AsesmenStatus;
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
        Schema::create('asesmen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesi_id')->constrained('asesi', 'id')->cascadeOnDelete();
            $table->foreignId('asesor_id')->constrained('asesor', 'id')->cascadeOnDelete();
            $table->foreignId('periode_id')->constrained('periode', 'id')->cascadeOnDelete();
            $table->foreignId('skema_id')->constrained('skema', 'id')->cascadeOnDelete();
            $table->string('tujuan')->nullable();
            $table->unsignedTinyInteger('status')->default(AsesmenStatus::REGISTRASI);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesmen');
    }
};
