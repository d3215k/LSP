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
        Schema::table('skema', function (Blueprint $table) {
            $table->boolean('tertulis_esai')->default(false);
            $table->unsignedInteger('durasi_tertulis_esai')->default(60);
            $table->boolean('tertulis_pg')->default(true);
            $table->unsignedInteger('durasi_tertulis_pg')->default(60);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skema', function (Blueprint $table) {
            $table->dropColumn('tertulis_esai');
            $table->dropColumn('durasi_tertulis_esai');
            $table->dropColumn('tertulis_pg');
            $table->dropColumn('durasi_tertulis_pg');
        });
    }
};
