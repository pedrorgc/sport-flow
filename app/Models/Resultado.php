<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
      protected $fillable = [
        'evento_id',
        '~inscricao_id',
        'posicao',
        'marca_pontuacao', 
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function inscricoes()
    {
        return $this->belongsTo(Inscricoes::class);
    }
}
