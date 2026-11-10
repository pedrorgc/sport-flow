<?php

use App\Models\Espaco;
use App\Models\Reserva;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    $this->user = User::factory()->gestor()->create();
    $this->actingAs($this->user);

    $this->espaco = Espaco::create([
        'nome' => 'Quadra 1',
        'endereco' => 'Rua A, 100',
        'tipo' => 'Quadra',
    ]);

    $modalidadeId = DB::table('modalidades')->insertGetId(['nome' => 'Futsal']);
    $novoEvento = fn (string $nome) => DB::table('eventos')->insertGetId([
        'nome' => $nome,
        'modalidade_id' => $modalidadeId,
        'data_inicio' => now()->addMonth(),
        'data_fim' => now()->addMonths(2),
    ]);
    $this->eventoA = $novoEvento('Campeonato A');
    $this->eventoB = $novoEvento('Campeonato B');

    // Segunda-feira de referência, sempre no futuro.
    $this->dia = Carbon::today()->next(Carbon::MONDAY)->addWeek();
});

function reservaExistente(array $attrs = []): Reserva
{
    $dia = test()->dia->format('Y-m-d');

    return Reserva::create(array_merge([
        'titulo' => 'Treino',
        'espaco_id' => test()->espaco->id,
        'responsavel_id' => test()->user->id,
        'data_hora_inicio' => "$dia 10:00:00",
        'data_hora_fim' => "$dia 12:00:00",
        'tipo' => 'Única',
        'status' => 'Confirmada',
    ], $attrs));
}

function payload(array $attrs = []): array
{
    return array_merge([
        'titulo' => 'Nova reserva',
        'espaco_id' => test()->espaco->id,
        'responsavel_id' => test()->user->id,
        'tipo' => 'Única',
        'data_reserva' => test()->dia->format('Y-m-d'),
        'hora_inicio' => '11:00',
        'hora_fim' => '13:00',
    ], $attrs);
}

test('reserva única em horário ocupado é recusada', function () {
    reservaExistente();

    $this->postJson(route('reservas.store'), payload())->assertStatus(422);

    expect(Reserva::count())->toBe(1);
});

test('evento oficial cancela reserva comum sobreposta', function () {
    $comum = reservaExistente();

    $this->postJson(route('reservas.store'), payload([
        'tipo' => 'Oficial',
        'titulo' => 'Final',
        'evento_id' => $this->eventoA,
    ]))->assertOk();

    expect($comum->fresh()->status)->toBe('Cancelada')
        ->and($comum->fresh()->justificativa_cancelamento)->toContain('Final')
        ->and(Reserva::where('tipo', 'Oficial')->where('status', 'Confirmada')->count())->toBe(1);
});

test('evento oficial não derruba outro evento oficial', function () {
    $oficial = reservaExistente(['tipo' => 'Oficial', 'evento_id' => $this->eventoA]);

    $this->postJson(route('reservas.store'), payload([
        'tipo' => 'Oficial',
        'evento_id' => $this->eventoB,
    ]))->assertStatus(422)->assertJsonPath('success', false);

    expect($oficial->fresh()->status)->toBe('Confirmada')
        ->and(Reserva::count())->toBe(1);
});

test('editar reserva para oficial aplica a mesma prioridade do cadastro', function () {
    $comum = reservaExistente();
    $outra = reservaExistente([
        'data_hora_inicio' => $this->dia->format('Y-m-d') . ' 14:00:00',
        'data_hora_fim' => $this->dia->format('Y-m-d') . ' 15:00:00',
    ]);

    $this->putJson(route('reservas.update', $outra), payload([
        'tipo' => 'Oficial',
        'evento_id' => $this->eventoA,
    ]))->assertOk();

    expect($comum->fresh()->status)->toBe('Cancelada')
        ->and($outra->fresh()->tipo)->toBe('Oficial')
        ->and($outra->fresh()->status)->toBe('Confirmada');
});

test('editar evento oficial para cima de outro oficial é recusado', function () {
    $oficialA = reservaExistente(['tipo' => 'Oficial', 'evento_id' => $this->eventoA]);
    $oficialB = reservaExistente([
        'tipo' => 'Oficial',
        'evento_id' => $this->eventoB,
        'data_hora_inicio' => $this->dia->format('Y-m-d') . ' 14:00:00',
        'data_hora_fim' => $this->dia->format('Y-m-d') . ' 15:00:00',
    ]);

    $this->putJson(route('reservas.update', $oficialB), payload([
        'tipo' => 'Oficial',
        'evento_id' => $this->eventoB,
    ]))->assertStatus(422);

    expect($oficialA->fresh()->status)->toBe('Confirmada')
        ->and($oficialB->fresh()->data_hora_inicio)->toContain('14:00');
});

test('editar reserva sem mudar o horário não conflita com ela mesma', function () {
    $reserva = reservaExistente();

    $this->putJson(route('reservas.update', $reserva), payload([
        'titulo' => 'Treino renomeado',
        'hora_inicio' => '10:00',
        'hora_fim' => '12:00',
    ]))->assertOk();

    expect($reserva->fresh()->titulo)->toBe('Treino renomeado');
});

test('reserva fixa cria uma ocorrência por dia da semana selecionado', function () {
    $this->postJson(route('reservas.store'), payload([
        'tipo' => 'Fixa',
        'dias_semana' => [1, 3], // segunda e quarta
        'data_limite_repeticao' => $this->dia->copy()->addDays(13)->format('Y-m-d'),
    ]))->assertOk();

    expect(Reserva::where('tipo', 'Fixa')->count())->toBe(4)
        ->and(Reserva::distinct()->count('grupo_reserva_id'))->toBe(1);
});

test('reserva fixa sem nenhuma data correspondente é recusada', function () {
    // Segunda a quarta, mas só sexta-feira selecionada.
    $this->postJson(route('reservas.store'), payload([
        'tipo' => 'Fixa',
        'dias_semana' => [5],
        'data_limite_repeticao' => $this->dia->copy()->addDays(2)->format('Y-m-d'),
    ]))->assertStatus(422)->assertJsonPath('success', false);

    expect(Reserva::count())->toBe(0);
});
