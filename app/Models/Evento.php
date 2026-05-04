<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = [
        'nome',
        'modalidade',
        'data_inicio',
        'data_fim',
        'prazo_inscricoes',
        'local',
        'status',
        'descrição',
    ];
}
