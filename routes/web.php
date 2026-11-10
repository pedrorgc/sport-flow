<?php

use App\Http\Controllers\AtletaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EspacoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\InscricoesController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResultadoController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ReservaController;
use App\Models\Inscricoes;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortalController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login-validar', [AuthController::class, 'authenticate'])->name('login.validar');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'ativo', 'senha.trocada'])->group(function () {

    Route::get('/perfil', [ProfileController::class, 'index'])->name('perfil.index');
    Route::put('/perfil/username', [ProfileController::class, 'updateUsername'])->name('perfil.username');
    Route::put('/perfil/password', [ProfileController::class, 'updatePassword'])->name('perfil.password');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Gestão de usuários: somente administrador.
    Route::middleware('papel:admin')->prefix('usuarios')->name('usuarios.')->group(function () {
        Route::get('/', [UsuarioController::class, 'index'])->name('index');
        Route::post('/', [UsuarioController::class, 'store'])->name('store');
        Route::put('/{usuario}', [UsuarioController::class, 'update'])->name('update');
        Route::patch('/{usuario}/acesso', [UsuarioController::class, 'alternarAcesso'])->name('acesso');
        Route::patch('/{usuario}/senha', [UsuarioController::class, 'redefinirSenha'])->name('senha');
    });

    // Escrita: administrador e gestor. Registradas antes das rotas de leitura
    // para que "/x/create" não seja capturado por "/x/{id}".
    Route::middleware('papel:gestor')->group(function () {
        Route::resource('atletas', AtletaController::class)->except(['index', 'show']);
        Route::resource('times', TimeController::class)->except(['index', 'show']);
        Route::resource('inscricoes', InscricoesController::class)->except(['index', 'show']);
        Route::resource('eventos', EventoController::class)->except(['index', 'show']);
        Route::resource('resultados', ResultadoController::class)->except(['index', 'show']);
        Route::resource('espacos', EspacoController::class)->except(['index', 'show']);
        Route::resource('reservas', ReservaController::class)->except(['index', 'show']);

        // Usada só pelo cadastro de resultados.
        Route::get('/api/eventos/{id}/inscricoes', function ($id) {
            return Inscricoes::with(['atleta.modalidade', 'time.modalidade'])
                ->where('evento_id', $id)
                ->where('status_inscricao', '!=', 'Cancelada')
                ->get();
        });
    });

    // Leitura: todos os papéis (monitor só consulta).
    Route::resource('atletas', AtletaController::class)->only(['index']);
    Route::resource('times', TimeController::class)->only(['index', 'show']);
    Route::resource('inscricoes', InscricoesController::class)->only(['index', 'show']);
    Route::resource('eventos', EventoController::class)->only(['index']);
    Route::resource('resultados', ResultadoController::class)->only(['index']);
    Route::resource('espacos', EspacoController::class)->only(['index']);
    Route::resource('reservas', ReservaController::class)->only(['index']);
    Route::get('/api/reservas-mensais', [ReservaController::class, 'getReservasMensais'])->name('reservas.api');
});
