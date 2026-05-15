<?php

namespace Database\Factories;

use App\Models\Evento;
use App\Models\Atleta;
use App\Models\Time;
use Illuminate\Database\Eloquent\Factories\Factory;

class InscricoesFactory extends Factory
{
    public function definition(): array
    {
        return [
            'evento_id' => Evento::all()->random()->id,

            'atleta_id' => null,

            'time_id' => Time::all()->random()->id,

            'status_inscricao' => fake()->randomElement([
                'Confirmada',
                'Pendente',
                'Cancelada'
            ]),
        ];
    }
}