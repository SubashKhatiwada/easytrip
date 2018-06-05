<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ClientSeatController extends Controller
{
//
//  public function __construct()
//  {
//      $this->middleware('guest');
//   }

    public function index()
    {
        $seat_info=DB::table('tbl_seat_info')->select('seat_id')->get();
//        return view('client-seat-view.seat',compact('seat_info'));

        return response()->view('client-seat-view.seat',compact('seat_info'));
//        return response()->json($seat_info);




    }
    public function fetch(){
        $seat_info=DB::table('tbl_seat_info')->select('seat_id')->get();
//        return view('client-seat-view.seat',compact('seat_info'));

        return response()->view('client-seat-view.fetchSeat',compact('seat_info'));
    }


}
