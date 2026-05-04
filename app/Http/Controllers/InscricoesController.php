<?php

namespace App\Http\Controllers;

use App\Models\Atleta;
use App\Models\Evento;
use App\Models\Inscricoes;
use App\Models\Time;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $validate = $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'tipo' => 'required|in:atleta,time',
            'atleta_id' => 'required_if:tipo,atleta|nullable|exists:atletas,id',
            'time_id' => 'required_if:tipo,time|nullable|exists:times,id',
            'status_inscricao' => 'required|string',
        ]);

        if ($validate['tipo'] === 'atleta') {
            $validate['time_id'] = null;
        } else {
            $validate['atleta_id'] = null;
        }

        unset($validate['tipo']);

        Inscricoes::create($validate);

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

    public function update(Request $request, string $id)
    {
        $inscricao = Inscricoes::findOrFail($id);

        $validate = $request->validate([
            'evento_id' => 'required|exists:eventos,id',
            'tipo' => 'required|in:atleta,time',
            'atleta_id' => 'required_if:tipo,atleta|nullable|exists:atletas,id',
            'time_id' => 'required_if:tipo,time|nullable|exists:times,id',
            'status_inscricao' => 'required|string',
        ]);

        if ($validate['tipo'] === 'atleta') {
            $validate['time_id'] = null;
        } else {
            $validate['atleta_id'] = null;
        }

        unset($validate['tipo']);

        $inscricao->update($validate);

        return redirect()->route('inscricoes.index')->with('success', 'Inscrição atualizada com sucesso!');
    }

    public function destroy(string $id)
    {
        $inscricao = Inscricoes::findOrFail($id);
        $inscricao->delete();

        return redirect()->route('inscricoes.index')->with('success', 'Inscrição removida com sucesso!');
    }
}
