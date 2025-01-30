<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // Relation avec l'événement réservé
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relation avec l'utilisateur qui a fait la réservation
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
