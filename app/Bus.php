<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $table = 'tbl_bus_details';
    protected $primaryKey='tbl_bus_details_id';


    protected $fillable = [
        'bus_name','bus_number', 'bus_type','number_of_seats',
    ];

}