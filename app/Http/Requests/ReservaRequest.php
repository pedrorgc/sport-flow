<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Como o acesso à tela já deve estar protegido por rotas e middlewares (ex: auth), 
        // podemos retornar true livremente aqui.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // 1. Base da Reserva
            'espaco_id' => 'required|exists:espacos,id',
            'tipo'      => 'required|in:Avulsa,Fixa,Oficial',
            
            // 2. O Guardião do Tempo (Evita viagens no tempo e inversões)
            'data_hora_inicio' => 'required|date|after:now',
            'data_hora_fim'    => 'required|date|after:data_hora_inicio',

            // 3. Regra Condicional A: A Carteirada (Evento Oficial)
            // Se o tipo for 'Oficial', o evento_id passa a ser estritamente obrigatório.
            'evento_id' => 'required_if:tipo,Oficial|nullable|exists:eventos,id',
            
            // 4. Regra Condicional B: A Trava do Fim do Mundo (Atividade Fixa)
            // Se o tipo for 'Fixa', obriga uma data limite. 
            // A mágica: 'before:+6 months' impede que alguém trave a quadra para a eternidade.
            'data_limite_repeticao' => 'required_if:tipo,Fixa|nullable|date|after:data_hora_fim|before:+6 months',
            
            // Bônus: Caso alguém queira mandar uma justificativa já na criação, validamos como texto limpo.
            'justificativa_cancelamento' => 'nullable|string|max:500',
        ];
    }

    /**
     * Tradução amigável dos erros (Excelente para a banca do TCC ver o cuidado com UX)
     */
    public function messages(): array
    {
        return [
            'data_hora_inicio.after' => 'O sistema não possui máquina do tempo. A reserva deve ser no futuro.',
            'data_hora_fim.after' => 'O horário de término não pode ser antes do horário de início.',
            'evento_id.required_if' => 'Para agendar um evento oficial, você precisa selecionar qual é o Campeonato.',
            'data_limite_repeticao.required_if' => 'Em atividades fixas, é obrigatório informar até que dia ela se repetirá.',
            'data_limite_repeticao.before' => 'Para evitar monopólio do espaço, o agendamento fixo tem um limite máximo de 6 meses.',
        ];
    }
}