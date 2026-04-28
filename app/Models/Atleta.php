<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atleta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'data_nascimento',
        'cpf_rg',
        'categoria',
        'modalidade',
        'contato',
    ];

    public function times()
    {
        return $this->belongsToMany(Time::class);
    }
}