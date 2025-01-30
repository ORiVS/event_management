<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use HasFactory;

    // Relation avec les événements de cette catégorie
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
