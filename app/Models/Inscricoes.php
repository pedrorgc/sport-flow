<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscricoes extends Model
{
    protected $fillable = [
        'evento_id',
        'atleta_id',
        'time_id',
        'status_inscricao', 
    ];
}
