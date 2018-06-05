<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bus;
use Validator;
use Response;
use Illuminate\Support\Facades\Input;
use App\http\Requests;
class BusController extends Controller
{



    public function index(){
        $post = Bus::paginate(4);
        return view('bus.bus-detail',compact('post'));
    }

    public function addBus(Request $request){
        $rules = array(
            'bus_name' => 'required',
            'bus_number' => 'required',
            'bus_type' => 'required|string',
            'number_of_seats'=>'required|numeric',
        );
        $validator = Validator::make ( Input::all(), $rules);
        if ($validator->fails())
            return Response::json(array('errors'=> $validator->getMessageBag()->toarray()));

        else {
            $post = new Bus;
            $post->bus_name = $request->bus_name;
            $post->bus_number = $request->bus_number;
            $post->bus_type = $request->bus_type;
            $post->number_of_seats = $request->number_of_seats;
            $post->save();
            return response()->json($post);
        }
    }

    public function editBus(Request $request){

        $post = Bus::find ($request->tbl_bus_details_id);
        $post->bus_number = $request->bus_number;
        $post->bus_name = $request->bus_name;
        $post->bus_type = $request->bus_type;
        $post->number_of_seats=$request->number_of_seats;
        $post->save();
        return response()->json($post);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteBus(Request $request){
        $post = Bus::find ($request->tbl_bus_details_id);
        $post->delete();

        return response()->json();
    }
}