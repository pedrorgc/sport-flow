<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservaRequest;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReservaController extends Controller
{
    public function index()
    {
        //
    }

    /**
     * API Exclusiva para alimentar o Calendário do Front-end (Lazy Loading)
     */
    public function getReservasMensais(Request $request)
    {
        // O calendário (ex: FullCalendar) envia esses parâmetros automaticamente
        $start = $request->query('start');
        $end = $request->query('end');

        // 1. Buscamos as reservas com os relacionamentos necessários
        $query = Reserva::with('evento')
            ->where('status', 'Confirmada'); // No calendário visual, normalmente só mostramos as confirmadas

        // 2. Filtramos apenas as reservas do mês que o usuário está visualizando
        if ($start && $end) {
            $query->whereBetween('data_hora_inicio', [$start, $end]);
        }

        $reservas = $query->get();

        // 3. Mapeamos os dados do banco para o padrão exato que o Calendário exige
        $eventosCalendario = $reservas->map(function ($reserva) {
            
            // Define o título visual no calendário
            $titulo = 'Reserva ' . $reserva->tipo;
            if ($reserva->tipo === 'Oficial' && $reserva->evento) {
                $titulo = '🏆 ' . $reserva->evento->nome;
            }

            // Define a cor da "bolinha" ou do bloco no calendário
            $cor = match ($reserva->tipo) {
                'Oficial' => '#dc3545', // Vermelho (Prioridade máxima)
                'Fixa'    => '#0d6efd', // Azul (Atividades contínuas)
                'Avulsa'  => '#198754', // Verde (Agendamento comum)
                default   => '#6c757d'
            };

            return [
                'id'    => $reserva->id,
                'title' => $titulo,
                // O calendário exige o formato ISO8601 (ex: 2026-05-31T14:30:00)
                'start' => \Carbon\Carbon::parse($reserva->data_hora_inicio)->toIso8601String(),
                'end'   => \Carbon\Carbon::parse($reserva->data_hora_fim)->toIso8601String(),
                'color' => $cor,
                
                // Variáveis extras que o Raí pode usar para preencher um modal ao clicar no evento
                'extendedProps' => [
                    'tipo'   => $reserva->tipo,
                    'status' => $reserva->status,
                    'espaco_id' => $reserva->espaco_id
                ]
            ];
        });

        // 4. Retorna o JSON puro para o JavaScript consumir
        return response()->json($eventosCalendario);
    }

    public function create()
    {
        //
    }

    public function store(ReservaRequest $request)
    {
        $dados = $request->validated();

        try {
            DB::transaction(function () use ($dados) {

                $inicio = Carbon::parse($dados['data_hora_inicio']);
                $fim = Carbon::parse($dados['data_hora_fim']);
                $tipo = $dados['tipo'];

                $grupoId = Str::uuid();

                $dados['status'] = 'Pendente';
                $dados['grupo_reserva_id'] = $grupoId;

                if ($tipo === 'Oficial') {
                    $motivo = 'Cancelado por sobreposição de Evento Oficial';
                    $this->derrubarConflitos($dados['espaco_id'], $inicio, $fim, $motivo);

                    Reserva::create($dados);
                } elseif ($tipo === 'Fixa') {
                    $limite = Carbon::parse($dados['data_limite_repeticao'])->endOfDay();

                    $atualInicio = $inicio->copy();
                    $atualFim = $fim->copy();

                    while ($atualInicio->lte($limite)) {

                        if ($this->existeConflito($dados['espaco_id'], $atualInicio, $atualFim)) {
                            throw new \Exception('Conflito detectado no dia '.$atualInicio->format('d/m/Y').'. O espaco não está livre em todas as semanas deste período.');
                        }

                        $dadosRepeticao = $dados;
                        $dadosRepeticao['data_hora_inicio'] = $atualInicio;
                        $dadosRepeticao['data_hora_fim'] = $atualFim;

                        Reserva::create($dadosRepeticao);

                        $atualInicio->addWeek();
                        $atualFim->addWeek();
                    }
                } else {
                    if ($this->existeConflito($dados['espaco_id'], $inicio, $fim)) {
                        throw new \Exception('O horário selecionado já está ocupado por outra atividade confirmada');
                    }

                    Reserva::create($dados);
                }
            });

            return redirect()->route('reservas.index')->with('success', 'Reserva(s) processada(s) com sucesso!');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['conflito' => $e->getMessage()]);
        }
    }

    private function existeConflito($espacoId, $inicio, $fim)
    {
        return Reserva::where('espaco_id', $espacoId)->where('status', 'Confirmada')->where(function ($query) use ($inicio, $fim) {
            $query->where('data_hora_inicio', '<', $fim)->where('data_hora_fim', '>', $inicio);
        })->exists();
    }

    private function derrubarConflitos($espacoId, $inicio, $fim, $motivo)
    {
        Reserva::where('espaco_id', $espacoId)
            ->where('status', 'Confirmada')
            ->where(function ($query) use ($inicio, $fim) {
                $query->where('data_hora_inicio', '<', $fim)
                    ->where('data_hora_fim', '>', $inicio);
            })
            ->update([
                'status' => 'Cancelada',
                'justificativa_cancelamento' => $motivo,
            ]);
    }
}
