<?php

namespace App\Http\Controllers;

use App\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class SearchController extends Controller
{
    public function searchBus(Request $request)
    {
        // return Carbon::parse($request->onward_date)->toDateString();
        $search_result=DB::table('tbl_bus_trip_schedule')
         ->join('tbl_bus_details','tbl_bus_trip_schedule.tbl_bus_details_id','=','tbl_bus_details.tbl_bus_details_id')
        ->join('tbl_route_details','tbl_bus_trip_schedule.tbl_bus_details_id','=','tbl_route_details.tbl_bus_details_id')
        ->where('tbl_bus_trip_schedule.source','=',$request->source)
        ->where('tbl_bus_trip_schedule.destination','=',$request->destination)
        ->whereDate('tbl_bus_trip_schedule.onward_date','=',Carbon::parse($request->onward_date)->toDateString())
        // ->get();
        ->toSql();
        return $search_result;
        // return view('listOfBus',compact('search_result'));
    }
}
