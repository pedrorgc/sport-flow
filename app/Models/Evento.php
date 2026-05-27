<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inscricao;
use App\Models\Modalidade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'nome',
        'modalidade_id',
        'data_inicio',
        'data_fim',
        'inscricao_inicio',
        'inscricao_fim',
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

    public function resultados()
    {
        return $this->hasMany(Resultado::class);
    }
}
