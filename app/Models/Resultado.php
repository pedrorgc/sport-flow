<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resultado extends Model
{
    use HasFactory,SoftDeletes;

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