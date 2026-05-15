<?php

namespace Database\Factories;

use App\Models\Modalidade;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventoFactory extends Factory
{
    public function definition(): array
    {
        $dataInicio = fake()->dateTimeBetween('now', '+2 months');

        $dataFim = (clone $dataInicio)
            ->modify('+' . rand(1, 10) . ' days');

        $prazoInscricao = (clone $dataInicio)
            ->modify('-' . rand(1, 10) . ' days');

        return [
            'nome' => 'Evento ' . fake()->word(),

            'modalidade_id' => Modalidade::all()->random()->id,

            'data_inicio' => $dataInicio,

            'data_fim' => $dataFim,

            'prazo_inscricoes' => $prazoInscricao,

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