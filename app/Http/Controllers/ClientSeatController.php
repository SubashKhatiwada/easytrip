<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ClientSeatController extends Controller
{
//    private  $trip_id;

    public function __construct()
    {
       
        $this->middleware('auth:user');


    }

    public function index(Request $request,$value)
    {
            $trip_id=$value;
            $booked_seat=DB::table('tbl_seat_info')->select('seat_id')
                                ->where('trip_id',$trip_id)->get();
                                // return response()->json($booked_seat);
            // $seat_info=$value;
            $seat_map_obj=DB::table('tbl_admin_bus_seat_details')
            ->where('tbl_bus_trip_schedule.trip_id',$trip_id)
            ->join('tbl_bus_trip_schedule','tbl_admin_bus_seat_details.tbl_bus_details_id','=','tbl_bus_trip_schedule.tbl_bus_details_id')
            ->select('seat_map')
            ->get();
            $seat_map_obj->toArray();
            $seat_map=$seat_map_obj[0]->seat_map;
            // return response($seat_map);
            return response()->view('client-seat-view.seat',compact('seat_map','booked_seat'));
       
        
    }
    public function fetch(){
        $booked_seat=DB::table('tbl_seat_info')->select('seat_id')
        // ->where('tbl_bus_trip_schedule.trip_id',$this->$trip_id)
        ->get();
//        return view('client-seat-view.seat',compact('seat_info'));

        return response()->view('client-seat-view.fetchSeat',compact('booked_seat'));
    }


}
