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
        Schema::create('pengajuan_cuti', function (Blueprint $table) {
            $table->id();
            $table->integer('u_id');
            $table->date('tgl_izin');
            $table->char('status')->comment('i:izin, s:sakit');
            $table->text('keterangan');
            $table->integer('status_approved')->comment('0:pending, 1;Approve, 2:Reject');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengajuan_cuti');
    }
};
