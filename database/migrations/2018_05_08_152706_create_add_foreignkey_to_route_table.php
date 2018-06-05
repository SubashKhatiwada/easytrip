<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddForeignkeyToRouteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_route_details', function (Blueprint $table) {
            $table->integer('tbl_bus_details_id')->unsigned();
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
        Schema::table('tbl_route_details', function (Blueprint $table) {
            //
        });
    }
}
