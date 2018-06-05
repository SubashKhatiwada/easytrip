<?php

namespace App\Http\Controllers;

use App\Route;
use App\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Response;

use Illuminate\Support\Facades\Input;


class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');

    }

    public function index()
    {
        $route_details = DB::table('tbl_route_details')
            ->join('tbl_bus_details', 'tbl_route_details.tbl_bus_details_id', '=', 'tbl_bus_details.tbl_bus_details_id')
            ->distinct()
            ->select(['tbl_bus_details.tbl_bus_details_id',
                        'tbl_bus_details.bus_name',
                        'tbl_bus_details.bus_number',
                        'tbl_route_details.route_name',
                        'tbl_route_details.source',
                        'tbl_route_details.destination'])
            ->get();



        $route = DB::table('tbl_bus_trip_schedule')
            ->join('tbl_bus_details', 'tbl_bus_trip_schedule.tbl_bus_details_id', '=', 'tbl_bus_details.tbl_bus_details_id')
            ->get();
        return view('bus.bus-schedule', compact(['route_details', 'route']));
    }


    public function addSchedule(Request $request)
    {
        $rules = array(
            'route_name' => 'required|string',
            'trip_id' => 'required|string',

            'bus_name' => 'required|numeric',
            'source' => 'required|string',
            'destination' => 'required|string',
            'onward_date' => 'required',
            'arrival_time' => 'required',
            'departure_time' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return redirect('/add-schedule')->withErrors($validator)->withInput();
        } else {
            $trip = new Trip;
            $trip->route_name = $request->route_name;
            $trip->trip_id = $request->trip_id;
            $trip->tbl_bus_details_id = $request->bus_name;
            $trip->source = $request->source;
            $trip->destination = $request->destination;
            $trip->onward_date = $request->onward_date;
            $trip->arrival_time = $request->arrival_time;
            $trip->departure_time = $request->departure_time;
            $trip->save();
            $request->session()->flash('alert-success', 'Trip was successfully added!');
            return redirect('/add-schedule');
        }
    }


    public function viewSchedule(Request $request)
    {
        $trip_id = $request->tbl_bus_trip_schedule_id;
        $trip = DB::table('tbl_bus_trip_schedule')->
        where('tbl_bus_trip_schedule.tbl_bus_trip_schedule_id', '=', $trip_id)->get();

        return response()->json($trip);

    }


    public function updateschedule(Request $request)
    {
        $rules = array(
            'r_name' => 'required|string',
            't_id' => 'required|string',

            'b_name' => 'required|numeric',
            'b_source' => 'required|string',
            'b_destination' => 'required|string',
            'b_onward_date' => 'required',
            'b_arrival_time' => 'required',
            'b_departure_time' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toarray()));

        } else {
            $schedule = Trip::find($request->tbl_bus_trip_schedule_id);
            $schedule->trip_id = $request->t_id;
            $schedule->tbl_bus_details_id = $request->b_name;
            $schedule->source = $request->b_source;
            $schedule->destination = $request->b_destination;
            $schedule->onward_date = $request->b_onward_date;
            $schedule->arrival_time = $request->b_arrival_time;
            $schedule->departure_time = $request->b_departure_time;
            $schedule->save();
            return response()->json($schedule);

        }
    }


    public function deleteSchedule(Request $request)
    {
        $trip = Trip::find($request->tbl_bus_schedule_id);
        $trip->delete();
        return response()->json();
    }

}
