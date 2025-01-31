<?php

namespace App\Http\Controllers;


use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Event::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'location' => 'required',
            'organizer_id' => 'nullable|integer',
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time' => 'nullable|date_format:Y-m-d H:i:s|after_or_equal:start_time',
            'duration' => 'nullable|integer',
            'price' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|integer',
            'max_capacity' => 'nullable|integer',
        ]);

        $event = Event::create($fields);

        return $event;

    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return $event;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $fields = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'location' => 'required',
            'organizer_id' => 'nullable|integer',
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time' => 'nullable|date_format:Y-m-d H:i:s|after_or_equal:start_time',
            'duration' => 'nullable|integer',
            'price' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|integer',
            'max_capacity' => 'nullable|integer',
        ]);

        $event->update($fields);

        return $event;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return ['message' => 'Event deleted'];
    }
}
