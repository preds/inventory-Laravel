<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    // protected $table = 'media ';
    protected $fillable = [
        'photo',
        'photo_name',
        'photo_type',
        'photo_hash',
        'deleted',
    ];
}
