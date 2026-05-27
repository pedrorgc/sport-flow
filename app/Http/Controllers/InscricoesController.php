<?php

namespace App\Http\Controllers;

use App\Models\Atleta;
use App\Models\Evento;
use App\Models\Inscricoes; // Dica: O ideal no Laravel é o model ser Singular (Inscricao), mas deixei igual ao seu
use App\Models\Time;
use App\Http\Requests\InscricoesRequest;

class InscricoesController extends Controller
{
    public function index()
    {
        $inscricoes = Inscricoes::with('evento', 'atleta', 'time')->get();

        $eventos = Evento::query()->where('status', '!=', 'Cancelado')->get();
        $atletas = Atleta::query()->orderBy('nome')->get();
        $times = Time::query()->orderBy('nome')->get();

        return view('inscricoes.index', compact('inscricoes', 'eventos', 'atletas', 'times'));
    }

    public function create()
    {
        // 
    }

    public function store(InscricoesRequest $request)
    {
        Inscricoes::create($request->dadosTratados());

        return redirect()->route('inscricoes.index')->with('success', 'Inscrição realizada com sucesso!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $inscricao = Inscricoes::with('evento', 'atleta', 'time')->findOrFail($id);

        return response()->json($inscricao);
    }

    public function update(InscricoesRequest $request, string $id)
    {
        $inscricao = Inscricoes::findOrFail($id);

        $inscricao->update($request->dadosTratados());

        return redirect()->route('inscricoes.index')->with('success', 'Inscrição atualizada com sucesso!');
    }

    public function destroy(string $id)
    {
        $inscricao = Inscricoes::findOrFail($id);
        $inscricao->delete();

        return redirect()->route('inscricoes.index')->with('success', 'Inscrição removida com sucesso!');
    }
}