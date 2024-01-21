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
        Schema::table('rooms', function (Blueprint $table) {
            $table->integer('kursi_kuliah')->default(0);
            $table->integer('kursi_dosen')->default(0);
            $table->integer('meja_dosen')->default(0);
            $table->integer('ac')->default(0);
            $table->integer('kipas_angin')->default(0);
            $table->integer('whiteboard')->default(0);
            $table->integer('penghapus')->default(0);
            $table->integer('proyektor')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            //
        });
    }
};
