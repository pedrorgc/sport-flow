<?php

namespace App\Http\Controllers;

use App\Models\Time;
use App\Models\Atleta;
use App\Models\Modalidade;
use App\Http\Requests\TimeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TimeController extends Controller
{

    public function index(Request $request)
    {
        $query = Time::with('modalidade')->withCount('atletas');

        $query->when($request->search, function ($q, $search) {
            return $q->where('nome', 'like', "%{$search}%");
        });

        $query->when($request->modalidade_id, function ($q, $modalidade) {
            return $q->where('modalidade_id', $modalidade);
        });

        $query->when($request->categoria, function ($q, $categoria) {
            return $q->where('categoria', $categoria);
        });

        $times = $query->orderBy('nome')->get();
        $modalidades = Modalidade::pluck('nome', 'id');
        $todosAtletas = Atleta::with('modalidade')->orderBy('nome')->get();

        return view('times.index', compact('times', 'modalidades', 'todosAtletas'));
    }

    public function create()
    {
        //
    }

    public function store(TimeRequest $request)
    {
        $validate = $request->validated();

        if ($request->hasFile('brasao')) {
            $caminho = Storage::disk('public')->put('brasoes', $request->file('brasao'));
            $validate['brasao'] = $caminho;
        }

        Time::create($validate);

        return redirect()->route('times.index')->with('success', 'Equipe criada com sucesso!');
    }

    public function show(string $id)
    {
        // Consulta do elenco (usada também por quem só visualiza).
        $time = Time::with('atletas', 'modalidade')->findOrFail($id);
        return response()->json($time);
    }

    public function edit(string $id)
    {
        $time = Time::with('atletas', 'modalidade')->findOrFail($id);
        return response()->json($time);
    }

    public function update(TimeRequest $request, string $id)
    {
        $time = Time::findOrFail($id);

        if ($request->has('sync_atletas')) {
            $atletasIds = $request->input('atletas', []);

            $atletasInvalidos = Atleta::whereIn('id', $atletasIds)
                ->where('modalidade_id', '!=', $time->modalidade_id)
                ->pluck('nome');

            if ($atletasInvalidos->isNotEmpty()) {
                return redirect()->route('times.index')->with(
                    'error',
                    'Não é possível vincular atleta(s) de outra modalidade: ' . $atletasInvalidos->implode(', ') . '.'
                );
            }

            $time->atletas()->sync($atletasIds);
            return redirect()->route('times.index')->with('success', 'Elenco atualizado com sucesso!');
        }

        $validate = $request->validated();
        if ($request->hasFile("brasao")) {
            if ($time->brasao && Storage::disk('public')->exists($time->brasao)) {
                Storage::disk('public')->delete($time->brasao);
            }
            $caminho = Storage::disk('public')->put('brasoes', $request->file('brasao'));
            $validate['brasao'] = $caminho;
        }
        $time->update($validate);
        return redirect()->route('times.index')->with('success', 'Equipe atualizada com sucesso!');
    }

    public function destroy(string $id)
    {
        $time = Time::findOrFail($id);

        if ($time->brasao && Storage::disk('public')->exists($time->brasao)) {
            Storage::disk('public')->delete($time->brasao);
        }

        $time->atletas()->detach();
        $time->delete();

        return redirect()->route('times.index')->with('success', 'Equipe deletada com sucesso!');
    }
}
