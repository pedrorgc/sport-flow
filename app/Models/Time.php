<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Atleta;
use App\Models\Inscricoes;
use App\Models\Modalidade;

class Time extends Model
{
    protected $fillable = [
        'nome',
        'categoria',
        'modalidade_id',
    ];

    public function atletas()
    {
        return $this->belongsToMany(Atleta::class);
    }

    public function inscricoes()
    {
        return $this->hasMany(Inscricoes::class);
    }

    public function modalidade()
    {
        return $this->belongsTo(Modalidade::class);
    }
}
