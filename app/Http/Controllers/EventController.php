<?php

namespace App\Http\Controllers;


use App\Models\Event;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */

    public static function middleware(): array
    {
        return[
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }



    public function index(): \Illuminate\Database\Eloquent\Collection
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

        $event = $request->user()->create($fields);

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

        Gate::authorize('modify', $event);
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
        Gate::authorize('modify', $event);

        $event->delete();
        return ['message' => 'Event deleted'];
    }
}
