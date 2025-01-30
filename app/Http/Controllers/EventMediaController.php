<?php

namespace App\Http\Controllers;

use App\Models\EventMedia;
use App\Http\Requests\StoreEventMediaRequest;
use App\Http\Requests\UpdateEventMediaRequest;

class EventMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventMediaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EventMedia $eventMedia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventMediaRequest $request, EventMedia $eventMedia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventMedia $eventMedia)
    {
        //
    }
}
