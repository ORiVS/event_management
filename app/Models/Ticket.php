<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    // Relation avec l'événement auquel ce ticket appartient
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relation avec l'invité qui a acheté ce ticket
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    // Relation avec la catégorie de ticket
    public function category()
    {
        return $this->belongsTo(TicketCategory::class);
    }

    // Relation avec le paiement associé à ce ticket
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
