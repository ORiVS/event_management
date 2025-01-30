<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    // Relation avec l'utilisateur qui a ajouté l'événement aux favoris
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec l'événement ajouté aux favoris
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
