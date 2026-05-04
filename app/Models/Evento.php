<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inscricao;

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

    public function inscricoes()
    {
        return $this->hasMany(Inscricoes::class);
    }
}
