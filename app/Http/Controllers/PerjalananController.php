<?php

namespace App\Http\Controllers;

use App\Models\perjalanan;
use Illuminate\Http\Request;

class PerjalananController extends Controller
{
    //
    public function idjalan(){
        $id = perjalanan::get('id_perjalanan')->last();
        return $id['id_perjalanan'];
    }
    
    public function index(){
        $data = perjalanan::get()->last();
        echo $data; 

        //CREATE FORM 
        // return '
        // <form action="/trip" method="POST">
        //     <input type="text" name="latitude">
        //     <input type="text" name="longitude">
        //     <button type="submit">Submit</button>
        // </form>';

        // UPDATE FORM
        return 'x
        <form action="/trip" method="POST">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" value='.$data['id'].'>
            <input type="text" name="latitude">
            <input type="text" name="longitude">
            <button type="submit">Submit</button>
        </form>';
    }

    public function store(Request $request)
    {
        $validatedData = ([
            'id_perjalanan' => '1',
            'latitude' => $request['latitude'],
            'longitude' => $request['longitude'],
        ]);
        perjalanan::create($validatedData);
    }

    public function updateTrip(Request $request)
    {
        $validatedData = $request->validate([
            'longitude' => 'required',
            'latitude' => 'required',
            'time' => 'required'
        ]);
        // dd($request['id']);
        perjalanan::where('id','=',$request['id'])->update($validatedData);
        return redirect('/trip');
    }
}
