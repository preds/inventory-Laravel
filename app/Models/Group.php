<?php

// app/Models/Group.php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'level',
        'status',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_user');
    }
}
