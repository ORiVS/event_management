<?php

namespace App\Http\Controllers;


use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class EventController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Appliquer le middleware dans le constructeur.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
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

        $fields['user_id'] = $request->user()->id ?? $request->input('user_id');

        $event = Event::create($fields);

        return $event;

    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event): Event
    {
        return $event;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event): Event
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
    public function destroy(Event $event): array
    {
        Gate::authorize('modify', $event);

        $event->delete();
        return ['message' => 'Event deleted'];
    }
}
