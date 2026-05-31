<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EventoRequest extends FormRequest
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
        return [
            'nome' => 'required|string|max:255',
            'modalidade_id' => 'required|exists:modalidades,id',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date|after_or_equal:data_inicio',
            'inscricao_inicio' => 'required|date',
            'inscricao_fim' => 'required|date|after_or_equal:inscricao_inicio',
            'espaco_id' => 'nullable|exists:espacos,id',
            'descricao' => 'nullable|string',
            'status' => 'required|string',
            'regulamento_path' => 'nullable|file|mimes:pdf|max:5120',
        ];
    }
}
