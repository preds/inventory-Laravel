<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'localisation',
        'first_name',
        'last_name',
        'username',
        'password',
        'status',
        'last_login',
        'group_id', // Ajouté pour permettre l'assignation de groupe
        'password_reset_required',
        'photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function isAdmin()
{
    // Vérifie si l'utilisateur appartient à un groupe ayant le niveau 'Administrator'
    return $this->group->level === 'Administrator';
}
}
