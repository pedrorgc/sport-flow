<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Atleta;
use App\Models\Inscricoes;
use App\Models\Modalidade;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Time extends Model
{

    use HasFactory;

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
