<?php

namespace App\Http\Controllers;
use App\Models\jalan;

use Illuminate\Http\Request;

class mainAlgoController extends Controller
{
    //
    public function index(Request $request){
        $list = jalan::whereRaw('SQRT(POWER((longitude-?),2)+POWER((ABS(latitude)-ABS(?)),2))/0.0001*11.1<30')->setBindings([$request->lon,$request->lat])->get();
        return ['list'=>$list];
    }
}
