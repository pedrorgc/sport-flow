<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inscricoes extends Model
{
    use HasFactory,SoftDeletes;

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
        return $this->belongsTo(Atleta::class)->withTrashed();
    }

    public function time()
    {
        return $this->belongsTo(Time::class)->withTrashed();
    }
}
