<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->renameColumn('nama_kegiatan', 'keperluan');
            $table->string('keperluan')->after('end_time')->change();
        });
    }

    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->renameColumn('keperluan', 'nama_kegiatan');

            $table->string('nama_kegiatan')->after('date')->change();
        });
    }

};
