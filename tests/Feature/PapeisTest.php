<?php

use App\Enums\Papel;
use App\Models\User;
use Illuminate\Support\Facades\Route;

beforeEach(function () {
    Route::middleware(['web', 'auth', 'ativo', 'papel:gestor'])->get('/_teste/gestor', fn () => 'ok');
    Route::middleware(['web', 'auth', 'ativo', 'papel:admin'])->get('/_teste/admin', fn () => 'ok');
});

test('usuário novo é monitor e ativo por padrão', function () {
    $user = User::forceCreate(['name' => 'Novo', 'username' => 'NOVO', 'password' => 'secret']);

    expect($user->fresh()->role)->toBe(Papel::Monitor)
        ->and($user->fresh()->ativo)->toBeTrue();
});

test('role não pode ser definido por atribuição em massa', function () {
    $user = User::create(['name' => 'X', 'username' => 'X', 'password' => 'secret', 'role' => 'admin']);

    expect($user->fresh()->role)->toBe(Papel::Monitor);
});

test('helpers de papel refletem o papel do usuário', function () {
    $admin = User::factory()->admin()->make();
    $gestor = User::factory()->gestor()->make();
    $monitor = User::factory()->monitor()->make();

    expect($admin->isAdmin())->toBeTrue()->and($admin->podeGerenciar())->toBeTrue()
        ->and($gestor->isGestor())->toBeTrue()->and($gestor->podeGerenciar())->toBeTrue()
        ->and($monitor->isMonitor())->toBeTrue()->and($monitor->podeGerenciar())->toBeFalse();
});

test('middleware de papel libera gestor e administrador, mas bloqueia monitor', function () {
    $this->actingAs(User::factory()->gestor()->create())->get('/_teste/gestor')->assertOk();
    $this->actingAs(User::factory()->admin()->create())->get('/_teste/gestor')->assertOk();
    $this->actingAs(User::factory()->monitor()->create())->get('/_teste/gestor')->assertForbidden();
});

test('rota exclusiva de administrador bloqueia gestor e monitor', function () {
    $this->actingAs(User::factory()->admin()->create())->get('/_teste/admin')->assertOk();
    $this->actingAs(User::factory()->gestor()->create())->get('/_teste/admin')->assertForbidden();
    $this->actingAs(User::factory()->monitor()->create())->get('/_teste/admin')->assertForbidden();
});

test('usuário bloqueado não consegue fazer login', function () {
    User::factory()->bloqueado()->create(['username' => 'BLOQUEADO']);

    $this->post(route('login.validar'), ['username' => 'bloqueado', 'password' => 'password'])
        ->assertSessionHasErrors('username');

    $this->assertGuest();
});

test('usuário bloqueado com sessão aberta é deslogado na próxima requisição', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->get(route('reservas.index'))->assertOk();

    $user->forceFill(['ativo' => false])->save();

    $this->get(route('reservas.index'))->assertRedirect(route('login'));
    $this->assertGuest();
});
