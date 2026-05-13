<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inscricao;
use App\Models\Modalidade;

class Evento extends Model
{
    protected $fillable = [
        'nome',
        'modalidade_id',
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

    public function modalidade()
    {
        return $this->belongsTo(Modalidade::class);
    }
}
