<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    use HasFactory;

    protected $fillable = [
        'evento_id',
        'inscricao_id',
        'posicao',
        'marca_pontuacao',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function inscricao()
    {
        return $this->belongsTo(Inscricoes::class, 'inscricao_id');
    }
}