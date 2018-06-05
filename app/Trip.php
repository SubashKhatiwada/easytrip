<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    protected $table='tbl_bus_trip_schedule';
    protected $primaryKey='tbl_bus_trip_schedule_id';
    protected $fillable=['trip_id','route_name','tbl_bus_details_id','source','destination','onward_date','departure_time','arrival_time'];
}
