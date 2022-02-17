<?php

namespace App\Http\Controllers;

use App\Models\perjalanan;
use App\Http\Requests\StoreperjalananRequest;
use App\Http\Requests\UpdateperjalananRequest;

class PerjalananController extends Controller
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
     * @param  \App\Http\Requests\StoreperjalananRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreperjalananRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\perjalanan  $perjalanan
     * @return \Illuminate\Http\Response
     */
    public function show(perjalanan $perjalanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\perjalanan  $perjalanan
     * @return \Illuminate\Http\Response
     */
    public function edit(perjalanan $perjalanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateperjalananRequest  $request
     * @param  \App\Models\perjalanan  $perjalanan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateperjalananRequest $request, perjalanan $perjalanan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\perjalanan  $perjalanan
     * @return \Illuminate\Http\Response
     */
    public function destroy(perjalanan $perjalanan)
    {
        //
    }
}
