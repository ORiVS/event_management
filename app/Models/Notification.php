<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Relation avec l'utilisateur qui reçoit la notification
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
