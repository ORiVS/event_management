<?php

namespace App\EventManagement\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Relation avec les événements organisés par l'utilisateur
    public function event(): HasMany
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    // Relation avec les réservations faites par l'utilisateur
    public function reservations() : HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    // Relation avec les commentaires laissés par l'utilisateur
    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // Relation avec les notifications de l'utilisateur
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Relation avec les reviews laissées par l'utilisateur
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Relation avec les récompenses d'un utilisateur
    public function rewards()
    {
        return $this->hasOne(Reward::class);
    }

    // Relation avec les événements favoris de l'utilisateur
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // Relation avec les tickets d'un utilisateur
    public function tickets()
    {
        return $this->hasManyThrough(Ticket::class, Reservation::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

}
