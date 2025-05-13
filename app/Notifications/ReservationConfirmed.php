<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Reservation $reservation) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Confirmation de votre réservation')
            ->greeting("Bonjour {$notifiable->name},")
            ->line("Votre réservation pour l'événement « {$this->reservation->event->title} » a bien été prise en compte.")
            ->line("Nombre de places : {$this->reservation->number_of_places}")
            ->action('Voir l\'événement', url("/events/{$this->reservation->event_id}"))
            ->line('Merci pour votre confiance !');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => "Votre réservation pour l’événement « {$this->reservation->event->title} » est confirmée.",
            'event_id' => $this->reservation->event_id,
            'reservation_id' => $this->reservation->id,
        ];
    }
}
