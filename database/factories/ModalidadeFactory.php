<?php

namespace Database\Factories;

use App\Models\modalidade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<modalidade>
 */
class ModalidadeFactory extends Factory
{


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        return [
            "nome"=> fake()->unique()->randomElement(['Futsal', 'Futebol', 'Basquete', 'Vôlei', 'Handebol'])
        ];
    }
}
