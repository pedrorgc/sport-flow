<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventoController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login-validar', [AuthController::class, 'authenticate'])->name('login.validar');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::get('/atletas', function () {
        return view('atletas.index');
    })->name('atletas.index');

Route::get('/atletas', function () {
    return view('atletas.index');
});

Route::get('/resultados', function () {
    return view('resultados.index');
});
Route::get('/espacos', function () {
    return view('espacos.index');
});
    Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');
});
