<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Evento;
use App\Models\Time;
use App\Models\Atleta;
use Illuminate\Validation\Validator;

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

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Se houver falha nas regras básicas (ex: não enviou o ID), paramos por aqui para não quebrar a busca
            if ($validator->failed()) {
                return;
            }

            $eventoId = $this->input('evento_id');
            $evento = Evento::with('modalidade')->find($eventoId);

            if (!$evento) return;

            // 1. Validação de Prazo (Garantindo que pega até o final do dia)
            $hoje = now(config('app.timezone', 'America/Sao_Paulo'));
            $inicioInscricao = $evento->inscricao_inicio ? \Carbon\Carbon::parse($evento->inscricao_inicio)->startOfDay() : null;
            $fimInscricao = $evento->inscricao_fim ? \Carbon\Carbon::parse($evento->inscricao_fim)->endOfDay() : null;

            if (!$inicioInscricao || !$fimInscricao || $hoje->lt($inicioInscricao) || $hoje->gt($fimInscricao)) {
                $validator->errors()->add('evento_id', 'As inscrições para este evento estão encerradas ou fora do prazo.');
            }

            $tipo = $this->input('tipo');

            // 2. Validação de Tipo (Coletiva vs Individual)
            if ($evento->modalidade->tipo === 'Coletiva' && $tipo !== 'time') {
                $validator->errors()->add('tipo', 'Este evento é de modalidade Coletiva. Apenas equipes podem participar.');
            }

            if ($evento->modalidade->tipo === 'Individual' && $tipo !== 'atleta') {
                $validator->errors()->add('tipo', 'Este evento é de modalidade Individual. Apenas atletas avulsos podem participar.');
            }

            // 3. Compatibilidade da Modalidade (Futsal no Futsal)
            if ($tipo === 'time' && $this->filled('time_id')) {
                $time = Time::with('modalidade')->find($this->input('time_id'));
                if ($time && $time->modalidade_id !== $evento->modalidade_id) {
                    $validator->errors()->add('time_id', "Incompatibilidade: A equipe '{$time->nome}' pratica {$time->modalidade->nome}, mas o evento exige {$evento->modalidade->nome}.");
                }
            }

            if ($tipo === 'atleta' && $this->filled('atleta_id')) {
                $atleta = Atleta::with('modalidade')->find($this->input('atleta_id'));
                if ($atleta && $atleta->modalidade_id !== $evento->modalidade_id) {
                    $validator->errors()->add('atleta_id', "Incompatibilidade: O atleta '{$atleta->nome}' pratica {$atleta->modalidade->nome}, mas o evento exige {$evento->modalidade->nome}.");
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'evento_id.required' => 'Selecione um evento.',
            'evento_id.exists' => 'Evento inválido.',
            'tipo.required' => 'Selecione o tipo de inscrição (Atleta ou Time).',
            'tipo.in' => 'Tipo de inscrição inválido.',
            'atleta_id.required_if' => 'Selecione um atleta para inscrição individual.',
            'atleta_id.exists' => 'Atleta inválido.',
            'time_id.required_if' => 'Selecione um time para inscrição coletiva.',
            'time_id.exists' => 'Time inválido.',
            'status_inscricao.required' => 'O status da inscrição é obrigatório.',
        ];
    }

    /**
     * Retorna os dados já validados e formatados para o banco de dados.
     */
    public function dadosTratados(): array
    {
        $dados = $this->validated();

        if ($dados['tipo'] === 'atleta') {
            $dados['time_id'] = null;
        } else {
            $dados['atleta_id'] = null;
        }

        unset($dados['tipo']);

        return $dados;
    }
}