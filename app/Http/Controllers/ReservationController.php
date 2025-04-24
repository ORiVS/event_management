<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ReservationController extends BaseController
{

    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($request->user()->reservations()->with('event')->get());
    }

    public function store(Request $request, $event_id): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'number_of_places' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $event = Event::findOrFail($event_id);

        // Vérifier si l'événement a encore des places disponibles
        if ($event->max_capacity && $event->reservations()->sum('number_of_places') + $request->number_of_places > $event->max_capacity) {
            return response()->json(['message' => 'Not enough seats available'], 400);
        }

        $reservation = Reservation::create([
            'event_id' => $event->id,
            'user_id' => $request->user()->id,
            'number_of_places' => $request->number_of_places,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return response()->json($reservation, 201);
    }

    public function show(Reservation $reservation)
    {
        //
    }

    public function update(Request $request, Reservation $reservation): \Illuminate\Http\JsonResponse
    {
        $this->authorize('update', $reservation);

        $request->validate([
            'number_of_places' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $event = $reservation->event;
        $reservedSeats = $event->reservations()->sum('number_of_places') - $reservation->number_of_places;

        if ($event->max_capacity && $reservedSeats + $request->number_of_places > $event->max_capacity) {
            return response()->json(['message' => 'Not enough seats available'], 400);
        }

        $reservation->update([
            'number_of_places' => $request->number_of_places,
            'description' => $request->description,
        ]);

        return response()->json($reservation);
    }

    public function destroy(Reservation $reservation): \Illuminate\Http\JsonResponse
    {
        $this->authorize('delete', $reservation);

        $reservation->update(['status' => 'cancelled']);
        return response()->json(['message' => 'Reservation cancelled']);
    }
}
