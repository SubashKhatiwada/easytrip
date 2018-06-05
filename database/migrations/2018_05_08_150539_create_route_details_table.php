<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRouteDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_route_details', function (Blueprint $table) {
            $table->increments('tbl_route_details_id');
            $table->string('route_id');
            $table->string('route_name');
            $table->string('bus_name');
            $table->string('source');
            $table->string('destination');
            $table->string('boardingpoints');
            $table->string('fare');
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
        Schema::dropIfExists('tbl_route_details');
    }
}
