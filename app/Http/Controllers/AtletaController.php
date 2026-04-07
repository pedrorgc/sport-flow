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
            'cpf_rg' => 'nullable|string|max:255|unique:atletas,cpf_rg|max:20',
            'categoria' => 'required|string',
            'modalidade' => 'required|string',
            'contato' => 'nullable|string|max:255',
        ]);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
