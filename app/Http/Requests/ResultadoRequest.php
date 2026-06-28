<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResultadoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $resultadoId = $this->route('resultado');

        return [
            'evento_id' => 'required|exists:eventos,id',
            'inscricao_id' => 'required|exists:inscricoes,id',
            'posicao' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('resultados', 'posicao')
                    ->where('evento_id', $this->evento_id)
                    ->whereNull('deleted_at')
                    ->ignore($resultadoId),
            ],
            'marca_pontuacao' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'evento_id.required' => 'Selecione um evento.',
            'evento_id.exists' => 'Evento inválido.',
            'inscricao_id.required' => 'Selecione o vencedor (atleta ou time).',
            'inscricao_id.exists' => 'Participante inválido.',
            'posicao.required' => 'Informe a posição.',
            'posicao.integer' => 'A posição deve ser um número.',
            'posicao.min' => 'A posição deve ser no mínimo 1.',
            'posicao.unique' => 'Essa posição já foi registrada para este evento.',
            'marca_pontuacao.string' => 'A marca/pontuação deve ser um texto válido.',
        ];
    }
}
