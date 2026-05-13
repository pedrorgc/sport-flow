<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Time;
use App\Models\Modalidade;

class Atleta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'data_nascimento',
        'cpf_rg',
        'modalidade_id',
        'categoria',
        'contato',
    ];

    public function times()
    {
        return $this->belongsToMany(Time::class);
    }

    public function modalidade()
    {
        return $this->belongsTo(Modalidade::class);
    }
}