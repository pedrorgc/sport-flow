<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Time;
use App\Models\Atleta;
use App\Models\Modalidade;

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

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nome' => 'required|string|max:255',
            'categoria' => 'required|string',
            'modalidade_id' => 'required|exists:modalidades,id',
        ]);

        Time::create($validate);
        return redirect()->route('times.index')->with('success', 'Equipe criada com sucesso!');
    }

    public function show(string $id)
    {
        
    }

    public function edit(string $id)
    {
        $time = Time::with('atletas', 'modalidade')->findOrFail($id);
        return response()->json($time);
    }

    public function update(Request $request, string $id)
    {
        $time = Time::findOrFail($id);

        if ($request->has('sync_atletas')) {
            $time->atletas()->sync($request->input('atletas', []));
            return redirect()->route('times.index')->with('success', 'Elenco atualizado com sucesso!');
        }

        $validate = $request->validate([
            'nome' => 'required|string|max:255',
            'categoria' => 'required|string',
            'modalidade_id' => 'required|exists:modalidades,id',
        ]);

        $time->update($validate);
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