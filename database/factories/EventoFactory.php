<?php

namespace Database\Factories;

use App\Models\Modalidade;
use App\Models\Espaco; // <-- Nova importação do Model
use Illuminate\Database\Eloquent\Factories\Factory;

class EventoFactory extends Factory
{
    public function definition(): array
    {
        $dataInicio = fake()->dateTimeBetween('+1 month', '+3 months');

        $dataFim = (clone $dataInicio)
            ->modify('+' . rand(1, 10) . ' days');

        $inscricaoFim = (clone $dataInicio)
            ->modify('-' . rand(3, 7) . ' days');

        $inscricaoInicio = (clone $inscricaoFim)
            ->modify('-' . rand(10, 20) . ' days');

        return [
            'nome' => 'Evento ' . fake()->word(),

            'modalidade_id' => Modalidade::all()->random()->id,
            
            'espaco_id' => Espaco::all()->random()->id, 

            'data_inicio' => $dataInicio,

            'data_fim' => $dataFim,

            'inscricao_inicio' => $inscricaoInicio,
            'inscricao_fim' => $inscricaoFim,

            'descricao' => fake()->sentence(),

            'status' => fake()->randomElement([
                'Agendado',
                'Em Andamento',
                'Concluído',
                'Cancelado'
            ]),
        ];
    }
}