<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    use HasFactory;

    // Relation avec les tickets de cette catégorie
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
