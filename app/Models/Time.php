<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    protected $fillable = [
        'nome',
        'categoria',
        'modalidade',
    ];

    public function atletas()
    {
        return $this->belongsToMany(Atleta::class);
    }
}
