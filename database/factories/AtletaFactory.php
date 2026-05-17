<?php

namespace Database\Factories;

use App\Models\Atleta;
use App\Models\Modalidade;
use Illuminate\Database\Eloquent\Factories\Factory;

class AtletaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => fake()->name(),

            'cpf_rg' => fake()->boolean()
                ? fake()->unique()->numerify('###.###.###-##')
                : fake()->unique()->numerify('##.###.###-#'),

            'categoria' => fake()->randomElement([
                'Sub-15',
                'Sub-17',
                'Sub-20',
                'Adulto'
            ]),

            'data_nascimento' => fake()->dateTimeBetween('-35 years', '-10 years'),

            'modalidade_id' => Modalidade::all()->random()->id,
        ];
    }
}