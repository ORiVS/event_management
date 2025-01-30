<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    // Relation avec l'utilisateur associé
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
