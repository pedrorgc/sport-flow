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
        $query = Inscricoes::with(['evento.modalidade', 'atleta', 'time']);

        $query->when($request->evento_id, function ($q, $evento_id) {
            return $q->where('evento_id', $evento_id);
        });

        $inscricoes = $query->latest()->get(); 

        $eventos = Evento::with('modalidade')->where('status', '!=', 'Cancelado')->get();
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
        $evento = Evento::findOrFail($request->evento_id);

        $hoje = now();

        if (
            $hoje->lt($evento->inscricao_inicio) ||
            $hoje->gt($evento->inscricao_fim)
        ) {
            return back()->withErrors([
                'inscricao' => 'As inscrições para este evento estão encerradas.',
            ]);
        }

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