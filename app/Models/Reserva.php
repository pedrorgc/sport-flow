<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reserva extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'titulo',
        'espaco_id',
        'evento_id',
        'responsavel_id',
        'data_hora_inicio',
        'data_hora_fim',
        'tipo',
        'status',
        'justificativa_cancelamento',
        'grupo_reserva_id',
    ];

    public function espaco()
    {
        return $this->belongsTo(Espaco::class);
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }
}