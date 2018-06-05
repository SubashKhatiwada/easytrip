<?php

namespace App\Http\Controllers;

use App\BoardingPoints;
use App\Bus;
use App\Route;
use Response;
use \Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RouteController extends Controller
{
    //
public function __construct()
{
    $this->middleware('auth:admin');
}


    public function index()
    {
        $boardingpoints=DB::table('tbl_boarding_points_details')->get();
        $source=Bus::all();
        $route=DB::table('tbl_route_details')
                        ->join('tbl_bus_details','tbl_route_details.tbl_bus_details_id','=','tbl_bus_details.tbl_bus_details_id')
                        ->get();
        return view('bus.route',compact(['route','boardingpoints','source']));
    }


    public function addRoute(Request $request){
        $rules=array(
            'route_id'=>'required',
            'route_name'=>'required',
            'bus_name'=>'required',
            'source'=>'required',
            'destination'=>'required',
            'boardingpoints'=>'required',
            'fare'=>'required',

        );

        $validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
//            return redirect('/route')->withErrors($validator)->withInput();
            return Response::json(array('errors'=> $validator->getMessageBag()->toarray()));

        }
        else{
            $route=new Route;
            $route->route_id=$request->route_id;
            $route->route_name=$request->route_name;
            $route->source=$request->source;
            $route->destination=$request->destination;
            $route->boardingpoints=json_encode($request->boardingpoints);
            $route->fare=$request->fare;
            $route->tbl_bus_details_id=$request->bus_name;
            $route->save();
            $request->session()->flash('alert-success', 'Route was successfully added!');
//            return redirect('/route');
            return response()->json($route);

        }
    }





    public function update(Request $request){
       /* $rules=array(
            'route_id'=>'required',
            'route_name'=>'required',
            'bus_name'=>'required',
            'source'=>'required',
            'destination'=>'required',
            'boardingpoints'=>'required',
            'fare'=>'required',

        );*/

        /*$validator=Validator::make(Input::all(),$rules);
        if($validator->fails()){
//            return redirect('/route')->withErrors($validator)->withInput();
            return Response::json(array('errors'=> $validator->getMessageBag()->toarray()));

        }
        else{*/
            $route=Route::find($request->tbl_route_details_id);
            $route->route_id=$request->route_id;
            $route->route_name=$request->route_name;
            $route->source=$request->source;
            $route->destination=$request->destination;
            $route->boardingpoints=json_encode($request->boardingpoints);
            $route->fare=$request->fare;
            $route->tbl_bus_details_id=$request->bus_name;
            $route->save();
//            $request->session()->flash('alert-success', 'Route was successfully added!');
//            return redirect('/route');
            return response()->json($route);

        }
//    }
}
