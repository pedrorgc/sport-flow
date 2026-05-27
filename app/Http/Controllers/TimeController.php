<?php

namespace App\Http\Controllers;

use App\Models\Time;
use App\Models\Atleta;
use App\Models\Modalidade;
use App\Http\Requests\TimeRequest; 

class TimeController extends Controller
{
    public function index()
    {
        $times = Time::withCount('atletas')->get(); 
        $modalidades = Modalidade::all()->pluck('nome', 'id');
        $todosAtletas = Atleta::all();

        return view('times.index', compact('times', 'modalidades', 'todosAtletas'));
    }

    public function create()
    {
        //
    }

    public function store(TimeRequest $request) 
    {
        Time::create($request->validated());
        
        return redirect()->route('times.index')->with('success', 'Equipe criada com sucesso!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $time = Time::with('atletas', 'modalidade')->findOrFail($id);
        return response()->json($time);
    }
    public function update(TimeRequest $request, string $id)
    {
        $time = Time::findOrFail($id);

        // O fluxo do elenco continua funcionando, mas agora os IDs foram validados!
        if ($request->has('sync_atletas')) {
            // Usamos $request->input porque 'atletas' pode vir vazio se o time não tiver ninguém
            $time->atletas()->sync($request->input('atletas', [])); 
            return redirect()->route('times.index')->with('success', 'Elenco atualizado com sucesso!');
        }

        $time->update($request->validated());
        
        return redirect()->route('times.index')->with('success', 'Equipe atualizada com sucesso!');
    }

    public function destroy(string $id)
    {
        $time = Time::findOrFail($id);
        
        $time->atletas()->detach();
        $time->delete();
        
        return redirect()->route('times.index')->with('success', 'Equipe deletada com sucesso!');
    }
}