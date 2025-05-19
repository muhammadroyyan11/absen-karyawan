<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus unique constraint dari kolom no_hp dan nik
            $table->dropUnique(['nik']);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kembali unique constraint jika di-rollback
            $table->unique('nik');
        });
    }
};
