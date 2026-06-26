<?php

namespace App\Http\Controllers;

use App\Models\Atleta;
use App\Models\Evento;
use App\Models\Inscricoes;
use App\Models\Time;
use App\Http\Requests\InscricoesRequest;
use Illuminate\Http\Request;

class InscricoesController extends Controller
{
    public function index(Request $request)
    {
        $query = Evento::with('modalidade')->withCount('inscricoes');

        $query->when($request->search, function ($q, $search) {
            return $q->where('nome', 'like', "%{$search}%");
        });

        $eventos = $query->latest()->get();
        
        $atletas = Atleta::with('modalidade')->orderBy('nome')->get();
        $times = Time::with('modalidade')->orderBy('nome')->get();

        return view('inscricoes.index', compact('eventos', 'atletas', 'times'));
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

    public function show(string $evento_id)
    {
        $inscricoes = Inscricoes::with(['atleta', 'time'])
            ->where('evento_id', $evento_id)
            ->latest()
            ->get();

        return response()->json($inscricoes);
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