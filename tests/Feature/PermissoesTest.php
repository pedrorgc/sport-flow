<?php

use App\Models\Espaco;
use App\Models\User;

$telas = ['/atletas', '/times', '/eventos', '/inscricoes', '/resultados', '/espacos', '/reservas', '/dashboard', '/perfil'];

$escritas = [
    ['post', '/atletas'], ['put', '/atletas/1'], ['delete', '/atletas/1'], ['get', '/atletas/1/edit'],
    ['post', '/times'], ['put', '/times/1'], ['delete', '/times/1'], ['get', '/times/1/edit'],
    ['post', '/eventos'], ['put', '/eventos/1'], ['delete', '/eventos/1'], ['get', '/eventos/1/edit'],
    ['post', '/inscricoes'], ['put', '/inscricoes/1'], ['delete', '/inscricoes/1'], ['get', '/inscricoes/1/edit'],
    ['post', '/resultados'], ['put', '/resultados/1'], ['delete', '/resultados/1'], ['get', '/resultados/1/edit'],
    ['post', '/espacos'], ['put', '/espacos/1'], ['delete', '/espacos/1'], ['get', '/espacos/1/edit'],
    ['post', '/reservas'], ['put', '/reservas/1'], ['delete', '/reservas/1'], ['get', '/reservas/1/edit'],
    ['get', '/api/eventos/1/inscricoes'],
];

test('monitor acessa as telas de consulta', function (string $tela) {
    $this->actingAs(User::factory()->monitor()->create())->get($tela)->assertOk();
})->with($telas);

test('monitor não consegue alterar dados', function (string $metodo, string $uri) {
    $this->actingAs(User::factory()->monitor()->create())
        ->{$metodo . 'Json'}($uri)
        ->assertForbidden();
})->with($escritas);

test('monitor consulta o elenco de um time e o calendário de reservas', function () {
    $this->actingAs(User::factory()->monitor()->create());

    // Time inexistente: passa pela permissão e chega ao controller (404), não é barrado (403).
    $this->getJson('/times/999')->assertNotFound();
    $this->getJson('/api/reservas-mensais')->assertOk();
});

test('gestor e administrador conseguem alterar dados', function (string $papel) {
    $user = User::factory()->{$papel}()->create();

    $this->actingAs($user)->post('/espacos', [
        'nome' => 'Ginásio',
        'endereco' => 'Rua B, 200',
        'tipo' => 'Ginásio',
        'capacidade' => 100,
    ])->assertRedirect();

    expect(Espaco::where('nome', 'Ginásio')->exists())->toBeTrue();
})->with(['gestor', 'admin']);

test('telas escondem os botões de alteração do monitor', function (string $tela, string $botao) {
    $botao = '<span class="d-none d-md-inline">' . $botao . '</span>';

    $this->actingAs(User::factory()->monitor()->create())->get($tela)->assertDontSee($botao, false);
    $this->actingAs(User::factory()->gestor()->create())->get($tela)->assertSee($botao, false);
})->with([
    ['/atletas', 'Novo Atleta'],
    ['/times', 'Novo Time'],
    ['/eventos', 'Novo Evento'],
    ['/espacos', 'Novo Espaço'],
    ['/reservas', 'Nova Reserva'],
]);
