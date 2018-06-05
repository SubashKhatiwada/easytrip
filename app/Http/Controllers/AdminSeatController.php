<?php

namespace App\Http\Controllers;

use App\AdminSeatLayout;
use App\Bus;
use Illuminate\Http\Request;

class AdminSeatController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');


    }

    public function index()
    {
        $bus_number = Bus::all();
        return view('admin-seat-view.seat_module', compact('bus_number'));
    }


    public function addSeatLayout(Request $request)
    {

        $layout = new AdminSeatLayout;
        $layout->tbl_bus_details_id=$request->bus_id;
        $layout->seat_map=$request->seatMap;
        $layout->total_seat=substr_count(($request->seatMap),"h");
        $layout->save();
        $request->session()->flash('alert-success', 'Seat Map Layout succesfully Added!');
        return redirect('/adminseat');

    }
}
