<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Bailleur extends Model
{
   
    protected $fillable = [
        'bailleur_name',
        'description',
        'abbreviation_code',
     
    ];
}
