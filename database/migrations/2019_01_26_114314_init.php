<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->increments('hotelId');
            $table->string('name')
                ->unique();
            $table->string('city');
            $table->integer('numRooms');
            $table->decimal('price', 8, 2);
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('roomId');
            $table->integer('hotelId')
                ->unsigned();
            $table->foreign('hotelId')
                ->references('hotelId')->on('hotels');
        });

        Schema::create('people', function (Blueprint $table) {
            $table->increments('personId');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('phone');
            $table->string('email');
        });

        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('reservationId');
            $table->integer('personId')
                ->unsigned();
            $table->foreign('personId')
                ->references('personId')->on('people');
            $table->integer('roomId')
                ->unsigned();
            $table->foreign('roomId')
                ->references('roomId')->on('rooms');
            $table->dateTime('toDate');
            $table->dateTime('fromDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('reservations');
        Schema::drop('people');
        Schema::drop('rooms');
        Schema::drop('hotels');
    }
}
