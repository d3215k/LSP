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
