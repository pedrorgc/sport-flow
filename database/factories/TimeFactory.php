<?php

namespace Database\Factories;

use App\Models\Modalidade;
use App\Models\Time;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Time>
 */
class TimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome'=>fake()->city() . ' ' . fake()->randomElement([
                'FC', 'Esporte Clube', 'Atlético', 'União', 'Sport Club',
            ]),
            'modalidade_id' => Modalidade::all()->random()->id,

            'categoria' => fake()->randomElement([
                'Sub-15',
                'Sub-17',
                'Sub-20',
                'Adulto'
            ]),
        ];
    }
}
