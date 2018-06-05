<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeatInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_seat_info', function (Blueprint $table) {
            $table->increments('tbl_seat_info_id');
            $table->string('seat_id');
            $table->string('trip_id');
            $table->string('passenger_name');
            $table->string('passenger_gender');
            $table->integer('passenger_age');
            $table->integer('seat_price');
            $table->string('reserved_by');
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
        Schema::dropIfExists('tbl_seat_info');
    }
}
