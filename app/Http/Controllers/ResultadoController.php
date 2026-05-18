<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resultado;
use App\Models\Evento;
use App\Models\Modalidade;
use App\Models\Time;
use App\Models\Atleta;

class ResultadoController extends Controller
{
    public function index()
    {
        return view('resultados.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'modalidade_id' => 'required|exists:modalidades,id',
            'categoria' => 'required|string',
            'tipo_resultado' => 'required|string',
            'descricao' => 'nullable|string',
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
        $resultado = Resultado::with('evento', 'modalidade')->findOrFail($id);
        return response()->json($resultado);
    }

    public function update(Request $request, string $id)
    {
        $resultado = Resultado::findOrFail($id);

        $validate = $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'modalidade_id' => 'required|exists:modalidades,id',
            'categoria' => 'required|string',
            'tipo_resultado' => 'required|string',
            'descricao' => 'nullable|string',
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
