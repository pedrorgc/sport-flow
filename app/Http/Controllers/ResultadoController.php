<?php

namespace App\Http\Controllers;

use App\Models\Resultado;
// use App\Models\Inscricoes;
use Illuminate\Http\Request;

class ResultadoController extends Controller
{
    // listar os resultados
    public function index()
    {
        $resultados = Resultado::with('evento', 'inscricoes')->get();

        return view('resultados.index', compact('resultados'));
    }

    // vai salvar os resultados
    public function store(Request $request)
    {
        $request->validate([
            'evento_id' => 'required',
            'inscricao_id' => 'required',
            'posicao' => 'required|integer',
        ]);

        // pra verificar se ja existe
        $existe = Resultado::query()
            ->where('evento_id', '=', $request->evento_id)
            ->where('posicao', '=', $request->posicao)
            ->exists();

        // se tiver
        if ($existe) {
            return back()->with('erro', 'Essa posição já existe nesse evento.');
        }

        // salvar
        Resultado::create([
            'evento_id' => $request->evento_id,
            'inscricao_id' => $request->inscricao_id,
            'posicao' => $request->posicao,
            'marca_pontuacao' => $request->marca_pontuacao,
        ]);

        return back()->with('sucesso', 'Resultado cadastrado!');
    }

    // excluir
    public function destroy(int $id)
    {
        Resultado::destroy($id);

        return back()->with('sucesso', 'Resultado excluído!');
    }
}
