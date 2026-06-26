<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo'         => 'required|string|max:150',
            'espaco_id'      => 'required|exists:espacos,id',
            'responsavel_id' => 'required|exists:users,id',
            'tipo'           => 'required|in:Única,Fixa,Oficial',
            
            'data_reserva'   => 'required|date',
            'hora_inicio'    => 'required|date_format:H:i',
            'hora_fim'       => 'required|date_format:H:i|after:hora_inicio',

            'evento_id'             => 'required_if:tipo,Oficial|nullable|exists:eventos,id',
            'data_limite_repeticao' => 'required_if:tipo,Fixa|nullable|date|after_or_equal:data_reserva|before:+6 months',
            
            'dias_semana'           => 'required_if:tipo,Fixa|array',
            'dias_semana.*'         => 'integer|between:1,7',

            'justificativa_cancelamento' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'hora_fim.after' => 'O horário de término não pode ser antes do horário de início.',
            'evento_id.required_if' => 'Para agendar um evento oficial, você precisa selecionar qual é o Campeonato.',
            'data_limite_repeticao.required_if' => 'Em atividades fixas, é obrigatório informar até que dia ela se repetirá.',
            'data_limite_repeticao.before' => 'O agendamento fixo tem um limite máximo de 6 meses.',
            'dias_semana.required_if' => 'Selecione pelo menos um dia da semana para a repetição da rotina.',
        ];
    }
}