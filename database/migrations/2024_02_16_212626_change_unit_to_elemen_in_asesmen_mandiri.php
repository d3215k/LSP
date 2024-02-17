<?php

use App\Models\Asesmen\JawabanMandiri;
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
        Schema::table('jawaban_mandiri', function (Blueprint $table) {
            $table->foreignId('elemen_id')->after('asesmen_mandiri_id')->constrained('elemen')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jawaban_mandiri', function (Blueprint $table) {
            $table->dropColumn('elemen_id');
        });
    }
};
