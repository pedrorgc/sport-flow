<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resultado;
use App\Models\Evento;
use App\Models\Inscricoes;
use App\Models\Modalidade;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ResultadoRequest;

class ResultadoController extends Controller
{
    public function index()
    {
        $eventos = Evento::with(['resultados' => function ($query) {
            $query->orderBy('posicao', 'asc');
        }, 'resultados.inscricao.atleta', 'resultados.inscricao.time', 'modalidade'])->get();

        return view('resultados.index', compact('eventos'));
    }

    public function create()
    {
        //
    }

    public function store(ResultadoRequest $request)
    {
        Resultado::create($request->validated());

        return redirect()->route('resultados.index')->with('success', 'Resultado registrado com sucesso!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $resultado = Resultado::with('evento', 'inscricao')->findOrFail($id);
        return response()->json($resultado);
    }

    public function update(ResultadoRequest $request, string $id)
    {
        $resultado = Resultado::findOrFail($id);

        $resultado->update($request->validated());

        return redirect()->route('resultados.index')->with('success', 'Resultado atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $resultado = Resultado::findOrFail($id);
        $resultado->delete();
        
        return redirect()->route('resultados.index')->with('success', 'Resultado excluído com sucesso!');
    }
}