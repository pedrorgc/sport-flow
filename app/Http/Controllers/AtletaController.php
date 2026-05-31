<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtletaRequest;
use App\Models\Atleta;
use App\Models\Modalidade;
use Illuminate\Http\Request;

class AtletaController extends Controller
{
    public function index(Request $request)
    {
        $query = Atleta::with('modalidade');

        $query->when($request->search, function ($q, $search) {
            return $q->where(function ($subQuery) use ($search) {
                $subQuery->where('nome', 'like', "%{$search}%")
                    ->orWhere('cpf_rg', 'like', "%{$search}%");
            });
        });

        $query->when($request->modalidade_id, function ($q, $modalidade) {
            return $q->where('modalidade_id', $modalidade);
        });

        $query->when($request->categoria, function ($q, $categoria) {
            return $q->where('categoria', $categoria);
        });

        $atletas = $query->orderBy('nome')->get();
        $modalidades = Modalidade::pluck('nome', 'id');

        return view('atletas.index', compact('atletas', 'modalidades'));
    }

    public function create()
    {
        //
    }

    public function store(AtletaRequest $request)
    {
        Atleta::create($request->validated());

        return redirect()->route('atletas.index')->with('success', 'Atleta criado com sucesso!');
    }

    public function show(string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        Atleta::destroy($id);

        return redirect()->route('atletas.index')->with('success', 'Atleta deletado com sucesso!');
    }

    public function edit(string $id)
    {
        $atleta = Atleta::findOrFail($id);

        return response()->json($atleta);
    }

    public function update(AtletaRequest $request, string $id)
    {

        Atleta::findOrFail($id)->update($request->validated());

        return redirect()->route('atletas.index')->with('success', 'Atleta atualizado com sucesso!');
    }
}
