<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminSeatLayout extends Model
{
    //
    protected $table = 'tbl_admin_bus_seat_details';
    protected $primaryKey = 'tbl_admin_bus_seat_details_id';
    protected $fillable = [
        'tbl_bus_details_id', 'seat_map', 'total_seat',
    ];
}
