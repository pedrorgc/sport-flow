<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EspacoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'endereco' => 'required|string',
            'capacidade' => 'nullable|interger',

            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:3072',
        ]);

        if ($request->hasFile('foto')) {

            $caminho = $request->file('foto')
                ->store('espacos', 'public');
            $validate['foto'] = $caminho;
        }

        Espaco::create($validate);

        return redirect()
            ->route('espacos.index')
            ->with('success', 'Espaço cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $espaco = Espaco::findOrFail($id);

        $validate = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'capacidade' => 'nullable|integer',
            'endereco' => 'required|string',

            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
        ]);

        if ($request->hasFile('foto')) {

            $caminho = $request->file('foto')
                ->store('espacos', 'public');

            $validate['foto'] = $caminho;
        }

        $espaco->update($validate);

        return redirect()
            ->route('espacos.index')
            ->with('success', 'Espaço atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
