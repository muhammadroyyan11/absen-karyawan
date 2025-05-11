<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->foreignId('employment_type_id')
                ->after('name_shift')->nullable()
                ->constrained('employment_types')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->dropForeign(['employment_type_id']);
            $table->dropColumn('employment_type_id');
        });
    }
};
