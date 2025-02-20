<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Relation avec l'organisateur (User)
    public function organizer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    // Relation avec les catégories d'événements
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(EventCategory::class, 'category_id');
    }

    // Relation avec les médias associés à l'événement
    public function media(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EventMedia::class);
    }

    // Relation avec les réservations pour cet événement
    public function reservations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    // Relation avec les commentaires laissés pour cet événement
    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // Relation avec les tickets de cet événement
    public function tickets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    // Relation avec les reviews laissées pour cet événement
    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class);
    }

    // Relation avec les événements favoris
    public function favorites(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    protected $fillable = [
        'title',
        'description',
        'location',
        'organizer_id',
        'user_id',
        'start_time',
        'end_time',
        'duration',
        'price',
        'category_id',
        'max_capacity',
        'is_cancelled',
        'average_rating'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

}
