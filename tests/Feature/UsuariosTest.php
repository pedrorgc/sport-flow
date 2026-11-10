<?php

use App\Enums\Papel;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->admin = User::factory()->admin()->create(['username' => 'ADMIN']);
});

// --- Acesso à página ---

test('somente o administrador acessa a gestão de usuários', function (string $papel, int $status) {
    $this->actingAs(User::factory()->{$papel}()->create())
        ->get(route('usuarios.index'))
        ->assertStatus($status);
})->with([
    ['admin', 200],
    ['gestor', 403],
    ['monitor', 403],
]);

test('o item Usuários aparece no menu só para o administrador', function () {
    $link = 'href="/usuarios"';

    $this->actingAs($this->admin)->get(route('dashboard'))->assertSee($link, false);
    $this->actingAs(User::factory()->gestor()->create())->get(route('dashboard'))->assertDontSee($link, false);
});

test('gestor não consegue cadastrar, editar, bloquear nem redefinir senha', function () {
    $alvo = User::factory()->monitor()->create();
    $this->actingAs(User::factory()->gestor()->create());

    $this->post(route('usuarios.store'), ['name' => 'X', 'username' => 'XYZ', 'role' => 'admin'])->assertForbidden();
    $this->put(route('usuarios.update', $alvo), ['name' => 'X', 'username' => 'XYZ', 'role' => 'admin'])->assertForbidden();
    $this->patch(route('usuarios.acesso', $alvo))->assertForbidden();
    $this->patch(route('usuarios.senha', $alvo))->assertForbidden();

    expect($alvo->fresh()->role)->toBe(Papel::Monitor)->and($alvo->fresh()->ativo)->toBeTrue();
});

test('a lista mostra status, troca pendente e as ações certas para cada usuário', function () {
    User::factory()->gestor()->bloqueado()->create(['name' => "Ana D'Ávila", 'username' => 'ANA']);
    $pendente = User::factory()->monitor()->create(['username' => 'BRUNO']);
    $pendente->forceFill(['must_change_password' => true])->save();

    $html = $this->actingAs($this->admin)->get(route('usuarios.index'))->assertOk()->getContent();

    expect($html)->toContain('Aguardando troca de senha')
        ->toContain('"titulo":"Liberar acesso"')   // Ana, bloqueada
        ->toContain('"titulo":"Bloquear acesso"')  // Bruno, ativo
        ->toContain('D\\u0027\\u00c1vila')          // apóstrofo escapado no atributo
        ->not->toContain(route('usuarios.acesso', $this->admin))
        ->not->toContain(route('usuarios.senha', $this->admin));
});

// --- Cadastro ---

test('administrador cadastra usuário com senha temporária', function () {
    $resposta = $this->actingAs($this->admin)->post(route('usuarios.store'), [
        'name' => 'Maria Souza',
        'username' => 'maria.souza',
        'role' => 'monitor',
    ]);

    $resposta->assertRedirect(route('usuarios.index'))->assertSessionHas('senha_temporaria');

    $usuario = User::where('username', 'MARIA.SOUZA')->first();
    $senha = session('senha_temporaria')['senha'];

    expect($usuario)->not->toBeNull()
        ->and($usuario->role)->toBe(Papel::Monitor)
        ->and($usuario->ativo)->toBeTrue()
        ->and($usuario->must_change_password)->toBeTrue()
        ->and(strlen($senha))->toBe(10)
        ->and(Hash::check($senha, $usuario->password))->toBeTrue();
});

test('cadastro valida nome de usuário', function (string $username) {
    User::factory()->create(['username' => 'JA.EXISTE']);

    $this->actingAs($this->admin)
        ->post(route('usuarios.store'), ['name' => 'Fulano', 'username' => $username, 'role' => 'monitor'])
        ->assertSessionHasErrors('username');
})->with([
    'repetido' => 'ja.existe',
    'com espaço' => 'joao silva',
    'curto demais' => 'ab',
]);

test('cadastro recusa papel inválido', function () {
    $this->actingAs($this->admin)
        ->post(route('usuarios.store'), ['name' => 'Fulano', 'username' => 'FULANO', 'role' => 'superusuario'])
        ->assertSessionHasErrors('role');
});

// --- Edição ---

test('administrador altera nome, usuário e papel de outra pessoa', function () {
    $alvo = User::factory()->monitor()->create();

    $this->actingAs($this->admin)->put(route('usuarios.update', $alvo), [
        'name' => 'Novo Nome',
        'username' => 'novo.login',
        'role' => 'gestor',
    ])->assertRedirect(route('usuarios.index'));

    $alvo->refresh();
    expect($alvo->name)->toBe('Novo Nome')
        ->and($alvo->username)->toBe('NOVO.LOGIN')
        ->and($alvo->role)->toBe(Papel::Gestor);
});

test('administrador não altera o próprio papel', function () {
    $this->actingAs($this->admin)->put(route('usuarios.update', $this->admin), [
        'name' => $this->admin->name,
        'username' => 'ADMIN',
        'role' => 'monitor',
    ])->assertSessionHasErrors('role');

    expect($this->admin->fresh()->role)->toBe(Papel::Admin);
});

test('administrador edita o próprio nome mantendo o papel', function () {
    $this->actingAs($this->admin)->put(route('usuarios.update', $this->admin), [
        'name' => 'Admin Renomeado',
        'username' => 'ADMIN',
        'role' => 'admin',
    ])->assertSessionHasNoErrors();

    expect($this->admin->fresh()->name)->toBe('Admin Renomeado');
});

// --- Bloqueio ---

test('administrador bloqueia e libera o acesso de outra pessoa', function () {
    $alvo = User::factory()->gestor()->create();
    $this->actingAs($this->admin);

    $this->patch(route('usuarios.acesso', $alvo));
    expect($alvo->fresh()->ativo)->toBeFalse();

    $this->patch(route('usuarios.acesso', $alvo));
    expect($alvo->fresh()->ativo)->toBeTrue();
});

test('administrador não bloqueia o próprio acesso', function () {
    $this->actingAs($this->admin)
        ->patch(route('usuarios.acesso', $this->admin))
        ->assertSessionHasErrors('ativo');

    expect($this->admin->fresh()->ativo)->toBeTrue();
});

// --- Senha temporária ---

test('redefinir senha gera nova senha temporária e invalida a anterior', function () {
    $alvo = User::factory()->monitor()->create();

    $this->actingAs($this->admin)->patch(route('usuarios.senha', $alvo))->assertSessionHas('senha_temporaria');

    $alvo->refresh();
    expect(Hash::check('password', $alvo->password))->toBeFalse()
        ->and(Hash::check(session('senha_temporaria')['senha'], $alvo->password))->toBeTrue()
        ->and($alvo->must_change_password)->toBeTrue();
});

test('administrador não redefine a própria senha por esta página', function () {
    $this->actingAs($this->admin)
        ->patch(route('usuarios.senha', $this->admin))
        ->assertSessionHasErrors('senha');
});

test('quem tem senha temporária só acessa o perfil até trocá-la', function () {
    $usuario = User::factory()->monitor()->create();
    $usuario->forceFill(['must_change_password' => true])->save();
    $this->actingAs($usuario);

    $this->get(route('reservas.index'))->assertRedirect(route('perfil.index'));
    $this->get(route('perfil.index'))->assertOk()->assertSee('senha temporária');

    $this->put(route('perfil.password'), [
        'current_password' => 'password',
        'password' => 'novaSenha123',
        'password_confirmation' => 'novaSenha123',
    ])->assertSessionHasNoErrors();

    expect($usuario->fresh()->must_change_password)->toBeFalse();
    $this->get(route('reservas.index'))->assertOk();
});

test('nova senha precisa ser diferente da temporária', function () {
    $usuario = User::factory()->monitor()->create();
    $usuario->forceFill(['must_change_password' => true])->save();

    $this->actingAs($usuario)->put(route('perfil.password'), [
        'current_password' => 'password',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasErrors('password');

    expect($usuario->fresh()->must_change_password)->toBeTrue();
});

test('perfil mostra o papel real do usuário', function () {
    $this->actingAs(User::factory()->gestor()->create())
        ->get(route('perfil.index'))
        ->assertSee('Gestor');
});
