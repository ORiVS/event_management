<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReservationPolicy
{
    public function update(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->user_id;
    }

    public function delete(User $user, Reservation $reservation): bool
    {
        return $user->id === $reservation->user_id;
    }
}
