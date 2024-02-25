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
        Schema::table('asesmen', function (Blueprint $table) {
            $table->unique(['asesi_id', 'skema_id'], 'unique_asesi_skema_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asesmen', function (Blueprint $table) {
            $table->dropIndex('unique_asesi_skema_index');
        });
    }
};
