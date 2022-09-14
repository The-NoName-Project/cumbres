<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSportsRequest;
use App\Http\Requests\UpdateSportsRequest;
use App\Models\Sports;

class SportsController extends Controller
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
     * @param  \App\Http\Requests\StoreSportsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSportsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sports  $sports
     * @return \Illuminate\Http\Response
     */
    public function show(Sports $sports)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sports  $sports
     * @return \Illuminate\Http\Response
     */
    public function edit(Sports $sports)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSportsRequest  $request
     * @param  \App\Models\Sports  $sports
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSportsRequest $request, Sports $sports)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sports  $sports
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sports $sports)
    {
        //
    }
}
