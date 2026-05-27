<?php

namespace App\Http\Controllers;

use App\Models\Atleta;
use App\Models\Modalidade;
use App\Http\Requests\AtletaRequest;

class AtletaController extends Controller
{

    public function index()
    {
        $atletas = Atleta::with('modalidade')->get();
        $modalidades = Modalidade::all()->pluck('nome', 'id');

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
