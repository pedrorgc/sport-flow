<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\AtletaController;
use App\Http\Controllers\InscricoesController;

Route::get('/', function () {
    return view('portal.index');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login-validar', [AuthController::class, 'authenticate'])->name('login.validar');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/perfil', [ProfileController::class, 'index'])->name('perfil.index');
    Route::put('/perfil/username', [ProfileController::class, 'updateUsername'])->name('perfil.username');
    Route::put('/perfil/password', [ProfileController::class, 'updatePassword'])->name('perfil.password');

    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::resource('atletas', AtletaController::class);
    Route::resource('times', TimeController::class);
    Route::resource('inscricoes', InscricoesController::class);
    Route::resource('eventos', EventoController::class);

    Route::get('/resultados', function () {
        return view('resultados.index');
    })->name('resultados.index');

    Route::get('/espacos', function () {
        return view('espacos.index');
    })->name('espacos.index');

    Route::get('/reservas', function () {
        return view('reservas.index');
    })->name('reservas.index');

});

