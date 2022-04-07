<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jalan;
use PDO;

class MapsController extends Controller
{
    //
    public function index(){
        $input = [-8.6857521,115.2623214];
        $current_loc = [
            'lat' => -8.68906, 
            'lng' => 115.263493
        ];
        // $list = jalan::observe_prob($current_loc);
        // return response() ->json([
        //     'data'=> $list
        // ]);
        // $test = jalan::NCij();
        // $list = jalan::where(sqrt(pow((floatval('longitude')-115.2637692),2)+pow((abs(floatval('latitude'))-abs(-8.690674)),2))/0.0001*11.1,'<','30');
        // $list = jalan::whereRaw('SQRT(POWER((longitude-?),2)+POWER((ABS(latitude)-ABS(?)),2))/0.0001*11.1<30 AND status=1')->setBindings([$input[1],$input[0]])->get();
        $data = jalan::get(['point_id','latitude','longitude','status'])->take(100);
        
        // $list = jalan::whereRaw('SQRT(POWER((longitude-?),2)+POWER((ABS(latitude)-ABS(?)),2))/0.0001*11.1<30 AND status=1')->setBindings([$input[1], $input[0]])->get();
        // if(!$list->isEmpty()){
        //     return 'apaya';
        // }
        // else{
        //     return 'anda ada di zona larangan berhenti';
        // }
        
        return view('maps',[
            'data'=>$data,
            // 'list'=>$list
        ]);
    }

    public function maps(Request $request){
        $current_loc = [
            // 'longitude' => $request->longitude,
            // 'latitude' => $request->latitude
            'lng' => 115.262815,
            'lat' => -8.687415
        ];
        $list = jalan::observe_prob($current_loc);
        return response() ->json([
            'data'=> $list
        ]);
    }

    public function updateMaps(Request $request){
        jalan::where('point_id',$request->id)->update(['latitude'=>$request->lat,'longitude'=>$request->lng]);
        return redirect('/map');
    }
}
