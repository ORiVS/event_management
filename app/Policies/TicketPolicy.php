<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{

    public function manage(User $user, Ticket $ticket): bool
    {
        return $ticket->guest->user_id === $user->id ||
            $ticket->event->organizer_id === $user->id;
    }
}
