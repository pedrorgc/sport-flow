<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Atleta;

class Modalidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome'
    ];

    public function atletas()
    {
        return $this->hasMany(Atleta::class);
    } 
}