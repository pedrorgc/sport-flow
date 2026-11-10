<?php

use App\Models\User;

test('visitante é redirecionado para o login nas áreas internas', function (string $rota) {
    $this->get($rota)->assertRedirect(route('login'));
})->with(['/dashboard', '/reservas', '/atletas', '/eventos', '/espacos']);

test('usuário autenticado acessa a tela de reservas', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('reservas.index'))
        ->assertOk();
});

test('login com credenciais válidas autentica o usuário', function () {
    // O login converte o usuário para maiúsculas; o MySQL compara sem diferenciar caixa,
    // o SQLite dos testes diferencia, então o usuário é criado já em maiúsculas.
    $user = User::factory()->create(['username' => 'GESTOR']);

    $this->post(route('login.validar'), [
        'username' => 'gestor',
        'password' => 'password',
    ]);

    $this->assertAuthenticatedAs($user);
});
