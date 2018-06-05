<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoardingPoints extends Model
{
    //
    protected $table='tbl_boarding_points_details';
    protected $primaryKey='tbl_boarding_points_details_id';

    protected $fillable=['boarding_points_name'];
}
