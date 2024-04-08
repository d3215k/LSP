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
            $table->string('ttd_admin')->nullable()->before();
            $table->foreignId('admin_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asesmen', function (Blueprint $table) {
            $table->dropColumn('ttd_admin');
            $table->dropColumn('admin_id');
        });
    }
};
