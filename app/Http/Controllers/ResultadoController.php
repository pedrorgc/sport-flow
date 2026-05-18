<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resultado;
use App\Models\Evento;
use App\Models\Inscricoes; // Certifique-se de que o nome do Model está exatamente como o seu
use Illuminate\Validation\Rule;

class ResultadoController extends Controller
{
    public function index()
    {
        $resultados = Resultado::with(['evento', 'inscricao'])->get(); 
        $eventos = Evento::all(); 

        return view('resultados.index', compact('resultados', 'eventos'));
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