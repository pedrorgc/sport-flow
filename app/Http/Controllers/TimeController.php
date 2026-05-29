<?php

namespace App\Http\Controllers;

use App\Models\Time;
use App\Models\Atleta;
use App\Models\Modalidade;
use App\Http\Requests\TimeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\put;

class TimeController extends Controller
{
    public function index()
    {
        $times = Time::with('modalidade')->with('atletas')->get(); 
        $modalidades = Modalidade::all()->pluck('nome', 'id');
        $todosAtletas = Atleta::with('modalidade')->get();

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
            'brasao' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('brasao')){
            $caminho = Storage::disk('public')
            ->put('brasoes', $request->file('brasao'));
        }
        Time::create($validate);
        
        return redirect()
        ->route('times.index')
        ->with('success', 'Equipe criada com sucesso!');
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


    public function update(Request $request, string $id)
    {
        $time = Time::findOrFail($id);

        if ($request->has('sync_atletas')) {

            $time->atletas()->sync(
                $request->input('atletas', [])
            );

            return redirect()
            ->route('times.index')
            ->with('success', 'Elenco atualizado com sucesso!');
        }

        $validate = $request->validate([
            'nome' => 'required|string|max:255',
            'categoria' => 'required|string',
            'modalidade_id' => 'required|exists:modalidades,id',
            'brasao' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile("brasao")) {
            if($time->brasao && Storage::disk('public')->exists($time->brasao)){
                Storage::disk('public')->delete($time->brasao);
                
            }

            $caminho = Storage::disk('public')
            ->put('brasoes', $request->file('brasao'));
            
            $validate['brasao'] = $caminho;
        }



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