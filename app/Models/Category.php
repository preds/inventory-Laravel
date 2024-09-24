<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'category_name',
        'active',
        'photo_id', // Ajouter ce champ
    ];

    // Définir la relation avec le modèle Media
    public function media()
    {
        return $this->belongsTo(Media::class, 'photo_id');
    }

    public function assets() {
        return $this->hasMany(Asset::class);
    }
}
