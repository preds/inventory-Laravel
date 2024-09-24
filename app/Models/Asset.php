<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Asset extends Model
{
    protected $fillable = [
        // 'photo',
        'category_id',
        'localisation',
        'designation',
        'marque',
        'modele',
        'numero_serie_ou_chassis',
        'etat',
        'situation_exacte_du_materiel',
        'responsable',
        'quantite',
        'date_achat',
        'valeur',
        'numero_piece_comptables',
        'fournisseur',
        'bailleur',
        'projet',
        'date_de_sortie',
        'codification',
        'amortis',
        'deleted',
        'deleted_by',
        
    ];
    public function category()
    {
        
        return $this->belongsTo(Category::class, 'category_id');
        
}

public function media(): HasMany
{
    return $this->hasMany(Media::class);
}



public function designation()
{
    return $this->belongsTo(Designation::class, 'designation_id');
}


public function getDefaultDesignation()
{
    if ($this->designation_id) {
        return $this->designation_id;
    }

    return $this->designation;
}




    }

