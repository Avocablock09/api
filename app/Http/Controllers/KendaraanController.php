<?php

namespace App\Http\Controllers;

use App\Models\kendaraan;
use App\Http\Requests\StorekendaraanRequest;
use App\Http\Requests\UpdatekendaraanRequest;

class KendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StorekendaraanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorekendaraanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\kendaraan  $kendaraan
     * @return \Illuminate\Http\Response
     */
    public function show(kendaraan $kendaraan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\kendaraan  $kendaraan
     * @return \Illuminate\Http\Response
     */
    public function edit(kendaraan $kendaraan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatekendaraanRequest  $request
     * @param  \App\Models\kendaraan  $kendaraan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatekendaraanRequest $request, kendaraan $kendaraan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\kendaraan  $kendaraan
     * @return \Illuminate\Http\Response
     */
    public function destroy(kendaraan $kendaraan)
    {
        //
    }
}
