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
                Rule::unique('resultados', 'posicao')->where(function ($query) {
                    return $query->where('evento_id', $this->evento_id);
                })->ignore($resultadoId)
            ],
            'marca_pontuacao' => 'nullable|string',
        ];
    }
}
