<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Auth\Notifications\ResetPassword;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    // Relation avec les événements organisés par l'utilisateur
    public function event(): HasMany
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    // Relation avec les commentaires laissés par l'utilisateur
    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // Relation avec les notifications de l'utilisateur
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    // Relation avec les reviews laissées par l'utilisateur
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // Relation avec les récompenses d'un utilisateur
    public function rewards(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Reward::class);
    }

    // Relation avec les événements favoris de l'utilisateur
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    // Relation avec les tickets d'un utilisateur
    public function tickets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Ticket::class, Reservation::class);
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
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPassword($token));
    }
}
