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
            // Hapus index unique dari kolom no_hp
            $table->dropUnique(['no_hp']);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kembali unique jika migration di-rollback
            $table->unique('no_hp');
        });
    }
};
