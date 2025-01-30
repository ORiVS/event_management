<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Relation avec l'événement sur lequel ce commentaire est laissé
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relation avec l'utilisateur qui a laissé le commentaire
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
