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
        Schema::table('sekolah', function (Blueprint $table) {
            $table->string('alamat')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('no_fax')->nullable();
            $table->string('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sekolah', function (Blueprint $table) {
            $table->dropColumn('alamat');
            $table->dropColumn('kode_pos');
            $table->dropColumn('no_telepon');
            $table->dropColumn('no_fax');
            $table->dropColumn('email');
        });
    }
};
