<?php

namespace Database\Factories;

use App\Models\Modalidade;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventoFactory extends Factory
{
    public function definition(): array
    {
        // 1. Define quando o evento começa e termina
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

            'data_inicio' => $dataInicio,

            'data_fim' => $dataFim,

            'inscricao_inicio' => $inscricaoInicio,
            'inscricao_fim' => $inscricaoFim,

            'local' => fake()->randomElement([
                'Ginásio Municipal',
                'Arena Central',
                'Quadra Poliesportiva',
                'Estádio Municipal',
                'Centro Esportivo',
                'Ginásio do IFNMG',
                'Arena Almenara',
                'Complexo Esportivo Regional',
                'Praça de Esportes',
                'Campo Society Municipal'
            ]),

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