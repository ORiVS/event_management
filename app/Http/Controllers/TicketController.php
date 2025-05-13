<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Notification;
use App\Models\Ticket;
use App\Models\Guest;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller as BaseController;
use Barryvdh\DomPDF\Facade\Pdf;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Writer;

class TicketController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();

        if ($user->hasRole('admin')) {
            $tickets = Ticket::with('event', 'guest', 'category')->get();
        } elseif ($user->hasRole('organisateur')) {
            $tickets = Ticket::whereHas('event', function ($query) use ($user) {
                $query->where('organizer_id', $user->id);
            })->with('event', 'guest', 'category')->get();
        } else {
            $tickets = Ticket::whereHas('guest', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with('event', 'guest', 'category')->get();
        }

        return response()->json($tickets);
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

        if ($event->max_capacity && $event->tickets()->count() >= $event->max_capacity) {
            return response()->json(['message' => 'Event is fully booked'], 400);
        }

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
            'message' => "Vous avez réservé un nouveau ticket (#{$ticket->ticket_code}) pour l'événement « {$event->title} ». ",
            'status' => Notification::STATUS_PENDING,
        ]);
        $user = Guest::find($request->guest_id)->user ?? auth()->user(); // destinataire

        if ($user) {
            $user->notify(new \App\Notifications\TicketGenerated($ticket));
        }


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
        $this->authorize('manage', $ticket);

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
        $this->authorize('manage', $ticket);

        $ticket->delete();
        return response()->json(['message' => 'Ticket cancelled']);
    }

    /**
     * Télécharger un ticket en PDF avec QR code.
     */
    public function download(Ticket $ticket): \Illuminate\Http\Response
    {
        $this->authorize('manage', $ticket);

        $ticket->load('event', 'guest', 'category');

        $renderer = new ImageRenderer(
            new RendererStyle(150),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCode = base64_encode($writer->writeString($ticket->ticket_code));

        $user = auth()->user();

        $pdf = Pdf::loadView('tickets.pdf', compact('ticket', 'qrCode', 'user'));

        return $pdf->download("ticket_{$ticket->ticket_code}.pdf");
    }
}
