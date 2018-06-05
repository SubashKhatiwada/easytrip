<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminSeatTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_admin_bus_seat_details', function (Blueprint $table) {
            $table->increments('tbl_admin_bus_seat_details_id');
            $table->integer('tbl_bus_details_id')->unsigned();
            $table->string('seat_map');
            $table->integer('total_seat');
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
        Schema::dropIfExists('tbl_admin_bus_seat_details');
    }
}
