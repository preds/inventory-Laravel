<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    protected $table = 'task_logs'; // Indiquez le nom exact de votre table

    protected $fillable = ['status', 'message', 'created_at', 'updated_at']; // Ajoutez les champs modifiables
}
