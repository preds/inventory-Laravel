<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
   
    protected $fillable = [
        'projet_name',
        'description',
        'abbreviation_code',
     
    ];
}
