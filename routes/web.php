<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\ProfileController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login-validar', [AuthController::class, 'authenticate'])->name('login.validar');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/perfil', [ProfileController::class, 'index'])->name('perfil.index');
    Route::put('/perfil/username', [ProfileController::class, 'updateUsername'])->name('perfil.username');
    Route::put('/perfil/password', [ProfileController::class, 'updatePassword'])->name('perfil.password');

    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::get('/atletas', function () {
        return view('atletas.index');
    })->name('atletas.index');

    Route::get('/inscricoes', function () {
        return view('inscricoes.index');
    })->name('inscricoes.index');

    Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');

    Route::get('/resultados', function () {
        return view('resultados.index');
    })->name('resultados.index');

    Route::get('/espacos', function () {
        return view('espacos.index');
    })->name('espacos.index');

});
