<?php

namespace App\Http\Controllers;

use App\Models\jalan;
use App\Http\Requests\StorejalanRequest;
use App\Http\Requests\UpdatejalanRequest;

use function PHPUnit\Framework\isNull;

class JalanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAround($lat,$lon){

    }

    public function index(jalan $jalan)
    {
        return $jalan;
        $str_arr = preg_split("/\|/", $jalan);
        $lat = $str_arr[0];
        $lon = $str_arr[1];
        //
        // $current = 115.2605;
        // $n = jalan::NCij(32.9184);
        // echo('<br>'.$n);
        // $result = jalan::where('longitude','<',$current+0.0001)->orWhere('longitude','>',$current-0.0001)->get();
        // dd($result);
        // return view('jalan');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorejalanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorejalanRequest $request)
    {
        //
        // dd($request);
        $validatedData = $request->validate([
            'longitude' => 'required',
            'latitude' => 'required',
            'status' => ' required',
        ]);
        $request_long = $validatedData['longitude'];
        $request_lat = $validatedData['latitude'];
        $answer = jalan::where('longitude','=',$request_long)->Where('latitude','=',$request_lat)->get();
        if($answer->isempty()){
            
            jalan::create($validatedData);
        }
        // echo($longitude.$latitude);
        // dd($validatedData);
        // jalan::create($validatedData);
        // return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\jalan  $jalan
     * @return \Illuminate\Http\Response
     */
    public function show(jalan $jalan)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\jalan  $jalan
     * @return \Illuminate\Http\Response
     */
    public function edit(jalan $jalan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatejalanRequest  $request
     * @param  \App\Models\jalan  $jalan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatejalanRequest $request, jalan $jalan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\jalan  $jalan
     * @return \Illuminate\Http\Response
     */
    public function destroy(jalan $jalan)
    {
        //
    }
}
