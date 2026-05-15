<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscricoes extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'evento_id',
        'atleta_id',
        'time_id',
        'status_inscricao', 
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function atleta()
    {
        return $this->belongsTo(Atleta::class);
    }

    public function time()
    {
        return $this->belongsTo(Time::class);
    }
}
