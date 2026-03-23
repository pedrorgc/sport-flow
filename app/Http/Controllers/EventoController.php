<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = [
            [
                'nome' => 'Teste',
                'modalidade' => 'Futsal',
                'data' => '2026-03-21',
                'local' => 'Teste',
                'status' => 'Planejado',
                'descricao' => 'Teste teste'
            ]
        ];

        return view('eventos.index', compact('eventos'));
    }
}
