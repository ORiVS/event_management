<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Relation avec l'organisateur (User)
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    // Relation avec les catégories d'événements
    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'category_id');
    }

    // Relation avec les médias associés à l'événement
    public function media()
    {
        return $this->hasMany(EventMedia::class);
    }

    // Relation avec les réservations pour cet événement
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Relation avec les commentaires laissés pour cet événement
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Relation avec les tickets de cet événement
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    // Relation avec les reviews laissées pour cet événement
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Relation avec les événements favoris
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    protected $fillable = [
        'title',
        'description',
        'location',
        'organizer_id',
        'start_time',
        'end_time',
        'duration',
        'price',
        'category_id',
        'max_capacity',
        'is_cancelled',
        'average_rating'
    ];


}
