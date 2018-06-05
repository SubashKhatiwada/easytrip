<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusTripSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_bus_trip_schedule', function (Blueprint $table) {
            $table->increments('tbl_bus_trip_schedule_id');
            $table->string('trip_id');
            $table->integer('tbl_bus_details_id')->unsigned();
            $table->string('route_name');
            $table->string('source');
            $table->string('destination');
            $table->date('onward_date');
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->timestamps();
            $table->foreign('tbl_bus_details_id')->references('tbl_bus_details_id')->on('tbl_bus_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_bus_trip_schedule');
    }
}
