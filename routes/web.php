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
use App\Http\Controllers\ReservaController;
use App\Models\Inscricoes;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortalController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login-validar', [AuthController::class, 'authenticate'])->name('login.validar');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/perfil', [ProfileController::class, 'index'])->name('perfil.index');
    Route::put('/perfil/username', [ProfileController::class, 'updateUsername'])->name('perfil.username');
    Route::put('/perfil/password', [ProfileController::class, 'updatePassword'])->name('perfil.password');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('atletas', AtletaController::class);
    Route::resource('times', TimeController::class);
    Route::resource('inscricoes', InscricoesController::class);
    Route::resource('eventos', EventoController::class);
    Route::resource('resultados', ResultadoController::class);
    Route::get('/api/eventos/{id}/inscricoes', function ($id) {
        return Inscricoes::with(['atleta.modalidade', 'time.modalidade'])
            ->where('evento_id', $id)
            ->where('status_inscricao', '!=', 'Cancelada')
            ->get();
    });

    Route::resource('espacos', EspacoController::class);

    Route::resource('reservas', ReservaController::class);
    Route::get('/api/reservas-mensais', [App\Http\Controllers\ReservaController::class, 'getReservasMensais'])->name('reservas.api');
});
