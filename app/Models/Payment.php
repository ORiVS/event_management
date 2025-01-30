<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Relation avec le ticket associé à ce paiement
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
