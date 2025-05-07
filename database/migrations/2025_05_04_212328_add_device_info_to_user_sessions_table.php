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
        Schema::table('user_sessions', function (Blueprint $table) {
            $table->string('device_info')->nullable()->after('device_id');  // Menyimpan informasi User-Agent setelah device_id
            // Atau jika kamu ingin menambahkan device_type
             $table->string('device_type')->nullable()->after('device_info'); // Menyimpan informasi jenis perangkat setelah device_id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_sessions', function (Blueprint $table) {
            $table->dropColumn(['device_info', 'device_type']);
        });
    }
};
