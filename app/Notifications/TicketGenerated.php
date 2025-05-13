<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketGenerated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Ticket $ticket) {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Charger les relations
        $ticket = $this->ticket->load('event', 'guest', 'category');

        // Générer le QR Code
        $qr = new \BaconQrCode\Writer(
            new \BaconQrCode\Renderer\ImageRenderer(
                new \BaconQrCode\Renderer\RendererStyle\RendererStyle(150),
                new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
            )
        );

        $qrCode = base64_encode($qr->writeString($ticket->ticket_code));

        // Générer le PDF
        $pdf = Pdf::loadView('tickets.pdf', [
            'ticket' => $ticket,
            'qrCode' => $qrCode,
            'user' => $notifiable
        ]);

        return (new MailMessage)
            ->subject("Votre billet pour l'événement « {$ticket->event->title} »")
            ->greeting("Bonjour {$notifiable->name},")
            ->line("Merci pour votre réservation. Vous trouverez votre billet en pièce jointe.")
            ->line("Code billet : {$ticket->ticket_code}")
            ->attachData($pdf->output(), "ticket_{$ticket->ticket_code}.pdf", [
                'mime' => 'application/pdf',
            ])
            ->line('À bientôt !');
    }
}
