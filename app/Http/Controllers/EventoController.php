<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Modalidade;
use App\Models\Espaco; // <-- Importação do novo Model
use App\Http\Requests\EventoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::with(['modalidade', 'espaco'])->orderBy('data_inicio', 'asc')->get();
        $modalidades = Modalidade::pluck('nome', 'id');
        $espacos = Espaco::orderBy('nome')->pluck('nome', 'id');
        
        return view('eventos.index', compact('eventos', 'modalidades', 'espacos'));
    }

    public function create()
    {
        //
    }

    public function store(EventoRequest $request)
    {
        $dados = $request->validated();

        if ($request->hasFile('regulamento_path')) {
            $dados['regulamento_path'] = $request->file('regulamento_path')->store('regulamentos', 'public');
        }

        Evento::create($dados);
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
        $dados = $request->validated();

        if ($request->hasFile('regulamento_path')) {
            if ($evento->regulamento_path) {
                Storage::disk('public')->delete($evento->regulamento_path);
            }
            $dados['regulamento_path'] = $request->file('regulamento_path')->store('regulamentos', 'public');
        }

        $evento->update($dados);
        return redirect()->route('eventos.index')->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $evento = Evento::findOrFail($id);
        
        if ($evento->regulamento_path) {
            Storage::disk('public')->delete($evento->regulamento_path);
        }
        
        $evento->delete();
        return redirect()->route('eventos.index')->with('success', 'Evento excluído com sucesso!');
    }
}