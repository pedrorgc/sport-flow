<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;

class EventoController extends Controller
{
    public function index()
    {
    
        $eventos = Evento::orderBy('data_inicio', 'asc')->get();
        return view('eventos.index', compact('eventos'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nome' => 'required|string|max:255',
            'modalidade' => 'required|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'prazo_inscricoes' => 'required|date|before:data_inicio',
            'local' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'status' => 'required|string',
        ]);
        
        Evento::create($validate);
        return redirect()->route('eventos.index')->with('success', 'Evento criado com sucesso!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $evento = Evento::findOrFail($id);
        return response()->json($evento);
    }

    public function update(Request $request, string $id)
    {
        $evento = Evento::findOrFail($id);

        $validate = $request->validate([
            'nome' => 'required|string|max:255',
            'modalidade' => 'required|string',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'prazo_inscricoes' => 'required|date|before:data_inicio',
            'local' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $evento->update($validate);
        return redirect()->route('eventos.index')->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $evento = Evento::findOrFail($id);
        $evento->delete();
        return redirect()->route('eventos.index')->with('success', 'Evento excluído com sucesso!');
    }
}