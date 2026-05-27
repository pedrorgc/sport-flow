<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InscricoesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'evento_id' => 'required|exists:eventos,id',
            'tipo' => 'required|in:atleta,time',
            'atleta_id' => 'required_if:tipo,atleta|nullable|exists:atletas,id',
            'time_id' => 'required_if:tipo,time|nullable|exists:times,id',
            'status_inscricao' => 'required|string',
        ];
    }

    /**
     * Retorna os dados já validados e formatados para o banco de dados.
     */
    public function dadosTratados(): array
    {
    
        $dados = $this->validated();

        // Faz a lógica de anular o ID que não foi usado
        if ($dados['tipo'] === 'atleta') {
            $dados['time_id'] = null;
        } else {
            $dados['atleta_id'] = null;
        }

        // Remove o campo 'tipo' para não dar erro de coluna inexistente no banco
        unset($dados['tipo']);

        return $dados;
    }
}