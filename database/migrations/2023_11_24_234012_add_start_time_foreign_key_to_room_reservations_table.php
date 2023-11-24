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
        Schema::table('room_reservations', function (Blueprint $table) {
            $table->bigInteger('start_time')->unsigned()->index()->change(); 
            $table->foreign('start_time')->references('id')->on('sessions')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('room_reservations', function (Blueprint $table) {
            //
        });
    }
};
