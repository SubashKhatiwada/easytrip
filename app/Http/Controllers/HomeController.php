<?php

namespace App\Http\Controllers;


use App\Route;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cityname=Route::all();

        return view('home',compact('cityname'));
    }
}
