<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // Relation avec l'événement concerné
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relation avec l'utilisateur qui a laissé la revue
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
