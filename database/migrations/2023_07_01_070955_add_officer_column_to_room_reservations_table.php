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
            $table->string('building_officer')->nullable();
            $table->string('security_officer')->nullable();
            $table->string('clean_officer')->nullable();
            $table->string('logistic_officer')->nullable();
            $table->string('etc_officer')->nullable();
            $table->string('note')->nullable();
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
            $table->dropColumn('building_officer');
            $table->dropColumn('security_officer');
            $table->dropColumn('clean_officer');
            $table->dropColumn('logistic_officer');
            $table->dropColumn('etc_officer');
            $table->dropColumn('note');
        });
    }
};
