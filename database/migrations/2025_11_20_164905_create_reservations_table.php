<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('room_id');

            $table->string('nama_kegiatan');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');

            $table->enum('status', ['menunggu', 'diterima', 'ditolak', 'dibatalkan'])
                ->default('menunggu');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
