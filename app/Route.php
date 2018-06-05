<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    //
    protected $table='tbl_route_details';
    protected $primaryKey='tbl_route_details_id';


    protected $fillable=[
        'route_id','route_name','bus_name','source','destination','boardingpoints','fare','tbl_bus_details_id'
    ];
}
