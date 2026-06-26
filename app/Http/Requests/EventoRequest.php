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
            'data_fim' => 'required|date|after:data_inicio',
            'inscricao_inicio' => 'required|date|before_or_equal:data_inicio',
            'inscricao_fim' => 'required|date|after_or_equal:inscricao_inicio|before_or_equal:data_inicio',
            'espaco_id' => 'nullable|exists:espacos,id',
            'descricao' => 'nullable|string',
            'status' => 'required|string',
            'regulamento_path' => 'nullable|file|mimes:pdf|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'Informe o nome do evento.',
            'modalidade_id.required' => 'Selecione uma modalidade.',
            'data_inicio.required' => 'Informe a data de início.',
            'data_fim.after' => 'A data final deve ser posterior à data inicial.',
            'inscricao_inicio.before_or_equal' => 'As inscrições devem começar antes do evento.',
            'inscricao_fim.after_or_equal' => 'A inscrição final deve ser posterior ao início das inscrições.',
            'inscricao_fim.before_or_equal' => 'As inscrições devem terminar antes do início do evento.',
            'regulamento_path.mimes' => 'O regulamento deve estar em PDF.',
            'regulamento_path.max' => 'O arquivo deve possuir no máximo 5 MB.',
        ];
    }
}
