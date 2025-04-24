<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Notification;
use App\Models\Ticket;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as BaseController;


class TicketController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Ticket::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $event_id): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'category_id' => 'required|exists:ticket_categories,id',
        ]);

        $event = Event::findOrFail($event_id);

        // Vérifier si l'événement a encore de la place
        if ($event->max_capacity && $event->tickets()->count() >= $event->max_capacity) {
            return response()->json(['message' => 'Event is fully booked'], 400);
        }

        // Création du ticket
        $ticket = Ticket::create([
            'event_id' => $event->id,
            'guest_id' => $request->guest_id,
            'ticket_code' => Str::random(10),
            'issued_at' => Carbon::now(),
            'category_id' => $request->category_id,
            'payment_status' => 'pending',
        ]);

        Notification::create([
            'user_id' => $event->organizer_id ?? auth()->id(),
            'type' => Notification::TYPE_RESERVATION,
            'message' => "Vous avez réservé un nouveau ticket (#{$ticket->ticket_code}) pour l'événement « {$event->title} ».",
            'status' => Notification::STATUS_PENDING,
        ]);

        return response()->json($ticket->load('event', 'guest', 'category'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket): \Illuminate\Http\JsonResponse
    {
        return response()->json($ticket->load('event', 'guest', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'payment_status' => 'in:unpaid,pending,paid,cancelled',
        ]);

        $ticket->update($request->only('payment_status'));

        return response()->json($ticket);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket): \Illuminate\Http\JsonResponse
    {
        $ticket->delete();
        return response()->json(['message' => 'Ticket cancelled']);
    }
}
