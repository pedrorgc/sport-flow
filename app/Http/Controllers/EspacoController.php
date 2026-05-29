<?php

namespace App\Http\Controllers;

use App\Http\Requests\EspacoRequest;
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
    public function store(EspacoRequest $request)
    {
        $validate = $request->validated();

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
    public function update(EspacoRequest $request, string $id)
    {
        $espaco = Espaco::findOrFail($id);

        $validate = $request->validated();

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
