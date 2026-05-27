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

    public function store(Request $request)
    {
        $validate = $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'inscricao_id' => 'required|exists:inscricoes,id',
            'posicao' => [
                'required',
                'integer',
                Rule::unique('resultados', 'posicao')->where(function ($query) use ($request) {
                    return $query->where('evento_id', $request->input('evento_id'));
                }),
            ],
            'marca_pontuacao' => 'nullable|string', 
        ]);

        Resultado::create($validate);
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

    public function update(Request $request, string $id)
    {
        $resultado = Resultado::findOrFail($id);

        $validate = $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'inscricao_id' => 'required|exists:inscricoes,id',
            'posicao' => [
                'required',
                'integer',
                Rule::unique('resultados', 'posicao')->where(function ($query) use ($request) {
                    return $query->where('evento_id', $request->input('evento_id'));
                })->ignore($id),
            ],
            'marca_pontuacao' => 'nullable|string',
        ]);

        $resultado->update($validate);
        return redirect()->route('resultados.index')->with('success', 'Resultado atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $resultado = Resultado::findOrFail($id);
        $resultado->delete();
        
        return redirect()->route('resultados.index')->with('success', 'Resultado excluído com sucesso!');
    }
}