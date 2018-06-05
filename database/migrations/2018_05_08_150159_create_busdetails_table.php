<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_bus_details', function (Blueprint $table) {
            $table->increments('tbl_bus_details_id');
            $table->string('bus_name');
            $table->string('bus_number');
            $table->string('bus_type');
            $table->string('number_of_seats');
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
        Schema::dropIfExists('tbl_bus_details');
    }
}
