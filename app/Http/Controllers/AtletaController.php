<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atleta;

class AtletaController extends Controller
{

    public function index()
    {
        $atletas = Atleta::all();

        return view('atletas.index', compact('atletas'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'cpf_rg' => 'nullable|string|max:20|unique:atletas,cpf_rg|',
            'categoria' => 'required|string',
            'modalidade' => 'required|string',
            'contato' => 'nullable|string|max:255',
        ]);

        Atleta::create($validate);
        return redirect()->route('atletas.index')->with('success', 'Atleta criado com sucesso!');
    }

    public function show(string $id)
    {
        
    }

    public function edit(string $id)
    {
        $atleta = Atleta::findOrFail($id);
        return response()->json($atleta);
    }

    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'cpf_rg' => 'nullable|string|max:20|unique:atletas,cpf_rg,' . $id,
            'categoria' => 'required|string',
            'modalidade' => 'required|string',
            'contato' => 'nullable|string|max:255',
        ]);

        Atleta::findOrFail($id)->update($validate);
        return redirect()->route('atletas.index')->with('success', 'Atleta atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        Atleta::destroy($id);
        return redirect()->route('atletas.index')->with('success', 'Atleta deletado com sucesso!');
    }
}
