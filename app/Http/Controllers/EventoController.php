<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Modalidade;
use App\Http\Requests\EventoRequest;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::orderBy('data_inicio', 'asc')->get();
        $modalidades = Modalidade::all()->pluck('nome', 'id');
        return view('eventos.index', compact('eventos', 'modalidades'));
    }

    public function create()
    {
        //
    }

    public function store(EventoRequest $request)
    {
        Evento::create($request->validated());
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

    public function update(EventoRequest $request, string $id)
    {
        $evento = Evento::findOrFail($id);

        $evento->update($request->validated());
        return redirect()->route('eventos.index')->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $evento = Evento::findOrFail($id);
        $evento->delete();
        return redirect()->route('eventos.index')->with('success', 'Evento excluído com sucesso!');
    }
}