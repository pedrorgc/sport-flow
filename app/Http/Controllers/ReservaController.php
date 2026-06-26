<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservaRequest;
use App\Models\Espaco;
use App\Models\Evento;
use App\Models\Reserva;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReservaController extends Controller
{
    public function index(Request $request)
    {
        $espacos = Espaco::orderBy('nome')->get();
        $eventos = Evento::where('status', '!=', 'Cancelado')->orderBy('nome')->get();
        $usuarios = User::orderBy('name')->get(); 
        
        $reservas = Reserva::with(['espaco', 'evento', 'responsavel'])->orderBy('data_hora_inicio')->get();

        $dataFoco = $request->has('data') ? Carbon::parse($request->data) : Carbon::today();

        $inicioSemana = $dataFoco->copy()->startOfWeek(Carbon::MONDAY);
        $fimSemana = $dataFoco->copy()->endOfWeek(Carbon::SUNDAY);

        $meses = [1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'];
        $tituloSemana = $inicioSemana->format('d') . ' a ' . $fimSemana->format('d') . ' de ' . $meses[$inicioSemana->month] . ', ' . $inicioSemana->year;

        $semanaAnterior = $inicioSemana->copy()->subWeek()->format('Y-m-d');
        $proximaSemana = $inicioSemana->copy()->addWeek()->format('Y-m-d');

        return view('reservas.index', compact('espacos', 'eventos', 'usuarios', 'reservas', 'inicioSemana', 'tituloSemana', 'semanaAnterior', 'proximaSemana'));
    }

    public function getReservasMensais(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');
        $espacoId = $request->query('espaco_id');

        $query = Reserva::with(['evento', 'responsavel', 'espaco'])
            ->where('status', 'Confirmada'); 

        if ($espacoId) {
            $query->where('espaco_id', $espacoId);
        }

        if ($start && $end) {
            $query->whereBetween('data_hora_inicio', [$start, $end]);
        }

        $reservas = $query->get();

        $eventosCalendario = $reservas->map(function ($reserva) {
            $tituloExibicao = $reserva->titulo . ' (' . $reserva->tipo . ')';
            if ($reserva->tipo === 'Oficial') {
                $tituloExibicao = '🏆 ' . $reserva->titulo;
            }

            $cor = match ($reserva->tipo) {
                'Oficial' => '#dc3545', 
                'Fixa'    => '#0d6efd', 
                'Única'  => '#198754', 
                default   => '#6c757d'
            };

            return [
                'id'    => $reserva->id,
                'title' => $tituloExibicao,
                'start' => Carbon::parse($reserva->data_hora_inicio)->toIso8601String(),
                'end'   => Carbon::parse($reserva->data_hora_fim)->toIso8601String(),
                'color' => $cor,
                'extendedProps' => [
                    'titulo_puro' => $reserva->titulo,
                    'tipo'   => $reserva->tipo,
                    'status' => $reserva->status,
                    'espaco_id' => $reserva->espaco_id,
                    'responsavel_nome' => $reserva->responsavel->name ?? 'Não informado',
                    'espaco_nome'      => $reserva->espaco->nome ?? 'Espaço não definido',
                    'grupo_reserva_id' => $reserva->grupo_reserva_id
                ]
            ];
        });

        return response()->json($eventosCalendario);
    }

    public function store(ReservaRequest $request)
    {
        $dados = $request->validated();

        try {
            DB::transaction(function () use ($dados, $request) {

                $inicio = Carbon::parse($dados['data_reserva'] . ' ' . $dados['hora_inicio']);
                $fim    = Carbon::parse($dados['data_reserva'] . ' ' . $dados['hora_fim']);
                
                $dados['data_hora_inicio'] = $inicio->format('Y-m-d H:i:s');
                $dados['data_hora_fim']    = $fim->format('Y-m-d H:i:s');
                
                $tipo = $dados['tipo'];
                $dados['status'] = 'Confirmada';
                $dados['grupo_reserva_id'] = Str::uuid();

                // Armazena os dias da semana selecionados antes do limpar o array $dados
                $diasSelecionados = $request->input('dias_semana', []);

                unset($dados['data_reserva'], $dados['hora_inicio'], $dados['hora_fim'], $dados['data_limite_repeticao'], $dados['dias_semana']);

                if ($tipo === 'Oficial') {
                    $motivo = 'Cancelado por sobreposição de Evento Oficial: ' . $dados['titulo'];
                    $this->derrubarConflitos($dados['espaco_id'], $inicio, $fim, $motivo);

                    Reserva::create($dados);
                } 
                // INTELEGÊNCIA REESCRITA PARA MÚLTIPLOS DIAS EM LOTE
                elseif ($tipo === 'Fixa') {
                    $limite = Carbon::parse($request->input('data_limite_repeticao'))->endOfDay();
                    $atual = Carbon::parse($request->input('data_reserva'));

                    // Varre a folha do calendário dia por dia do início ao limite final
                    while ($atual->startOfDay()->lte($limite)) {
                        
                        if (in_array($atual->dayOfWeekIso, $diasSelecionados)) {
                            
                            $atualInicio = Carbon::parse($atual->format('Y-m-d') . ' ' . $request->input('hora_inicio'));
                            $atualFim    = Carbon::parse($atual->format('Y-m-d') . ' ' . $request->input('hora_fim'));

                            if ($this->existeConflito($dados['espaco_id'], $atualInicio, $atualFim)) {
                                throw new \Exception('Conflito detectado no dia ' . $atual->format('d/m/Y') . '. O espaço já está ocupado no horário selecionado.');
                            }

                            $dadosRepeticao = $dados;
                            $dadosRepeticao['data_hora_inicio'] = $atualInicio->format('Y-m-d H:i:s');
                            $dadosRepeticao['data_hora_fim']    = $atualFim->format('Y-m-d H:i:s');

                            Reserva::create($dadosRepeticao);
                        }
                        
                        $atual->addDay();
                    }
                } 
                else {
                    if ($this->existeConflito($dados['espaco_id'], $inicio, $fim)) {
                        throw new \Exception('O horário selecionado já está ocupado por outra atividade confirmada.');
                    }

                    Reserva::create($dados);
                }
            });

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Reserva(s) criada(s) com sucesso!']);
            }
            return redirect()->route('reservas.index')->with('success', 'Reserva processada com sucesso!');
            
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return back()->withInput()->withErrors(['conflito' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $reserva = Reserva::findOrFail($id);
        
        return response()->json([
            'id'             => $reserva->id,
            'titulo'         => $reserva->titulo,
            'espaco_id'      => $reserva->espaco_id,
            'responsavel_id' => $reserva->responsavel_id,
            'tipo'           => $reserva->tipo,
            'evento_id'      => $reserva->evento_id,
            'data_reserva'   => Carbon::parse($reserva->data_hora_inicio)->format('Y-m-d'),
            'hora_inicio'    => Carbon::parse($reserva->data_hora_inicio)->format('H:i'),
            'hora_fim'       => Carbon::parse($reserva->data_hora_fim)->format('H:i'),
            'grupo_id'       => $reserva->grupo_reserva_id
        ]);
    }

    public function update(ReservaRequest $request, $id)
    {
        $dados = $request->validated();
        $reserva = Reserva::findOrFail($id);

        try {
            DB::transaction(function () use ($dados, $request, $reserva) {
                $inicio = Carbon::parse($dados['data_reserva'] . ' ' . $dados['hora_inicio']);
                $fim    = Carbon::parse($dados['data_reserva'] . ' ' . $dados['hora_fim']);
                
                $dados['data_hora_inicio'] = $inicio->format('Y-m-d H:i:s');
                $dados['data_hora_fim']    = $fim->format('Y-m-d H:i:s');

                unset($dados['data_reserva'], $dados['hora_inicio'], $dados['hora_fim'], $dados['data_limite_repeticao'], $dados['dias_semana']);

                if ($request->input('alterar_grupo') == '1' && $reserva->grupo_reserva_id) {
                    
                    if ($this->existeConflitoEdicao($dados['espaco_id'], $inicio, $fim, $reserva->id)) {
                        throw new \Exception('O horário escolhido gera conflito para este dia inicial.');
                    }

                    $reserva->update($dados);

                    $proximasInstancias = Reserva::where('grupo_reserva_id', $reserva->grupo_reserva_id)
                        ->where('id', '!=', $reserva->id)
                        ->where('data_hora_inicio', '>', $reserva->data_hora_inicio)
                        ->get();

                    foreach ($proximasInstancias as $instancia) {
                        $dataInstancia = Carbon::parse($instancia->data_hora_inicio)->format('Y-m-d');
                        $novaInstanciaInicio = Carbon::parse($dataInstancia . ' ' . $request->hora_inicio);
                        $novaInstanciaFim    = Carbon::parse($dataInstancia . ' ' . $request->hora_fim);

                        if ($this->existeConflitoEdicao($dados['espaco_id'], $novaInstanciaInicio, $novaInstanciaFim, $instancia->id)) {
                            throw new \Exception('A alteração em lote falhou devido a um conflito na semana do dia ' . $novaInstanciaInicio->format('d/m/Y'));
                        }

                        $instancia->update([
                            'titulo'           => $dados['titulo'],
                            'espaco_id'        => $dados['espaco_id'],
                            'responsavel_id'   => $dados['responsavel_id'],
                            'evento_id'        => $dados['evento_id'] ?? null,
                            'data_hora_inicio' => $novaInstanciaInicio->format('Y-m-d H:i:s'),
                            'data_hora_fim'    => $novaInstanciaFim->format('Y-m-d H:i:s'),
                        ]);
                    }
                } else {
                    if ($this->existeConflitoEdicao($dados['espaco_id'], $inicio, $fim, $reserva->id)) {
                        throw new \Exception('O horário selecionado já está ocupado por outra atividade.');
                    }
                    
                    if ($reserva->tipo === 'Fixa' && $dados['tipo'] !== 'Fixa') {
                        $dados['grupo_reserva_id'] = null;
                    }

                    $reserva->update($dados);
                }
            });

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Reserva atualizada com sucesso!']);
            }
            return redirect()->route('reservas.index')->with('success', 'Reserva atualizada com sucesso!');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
            return back()->withInput()->withErrors(['conflito' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);

        if ($request->has('cancelar_grupo') && $reserva->grupo_reserva_id) {
            Reserva::where('grupo_reserva_id', $reserva->grupo_reserva_id)
                ->where('data_hora_inicio', '>=', $reserva->data_hora_inicio)
                ->delete();
                
            return redirect()->route('reservas.index')->with('success', 'Toda a rotina foi cancelada.');
        }

        $reserva->delete();
        return redirect()->route('reservas.index')->with('success', 'Reserva cancelada.');
    }

    private function existeConflito($espacoId, $inicio, $fim)
    {
        return Reserva::where('espaco_id', $espacoId)
            ->where('status', 'Confirmada')
            ->where(function ($query) use ($inicio, $fim) {
                $query->where('data_hora_inicio', '<', $fim)->where('data_hora_fim', '>', $inicio);
            })->exists();
    }

    private function existeConflitoEdicao($espacoId, $inicio, $fim, $ignoreId)
    {
        return Reserva::where('espaco_id', $espacoId)
            ->where('id', '!=', $ignoreId)
            ->where('status', 'Confirmada')
            ->where(function ($query) use ($inicio, $fim) {
                $query->where('data_hora_inicio', '<', $fim)->where('data_hora_fim', '>', $inicio);
            })->exists();
    }

    private function derrubarConflitos($espacoId, $inicio, $fim, $motivo)
    {
        Reserva::where('espaco_id', $espacoId)
            ->where('status', 'Confirmada')
            ->where(function ($query) use ($inicio, $fim) {
                $query->where('data_hora_inicio', '<', $fim)->where('data_hora_fim', '>', $inicio);
            })
            ->update([
                'status' => 'Cancelada',
                'justificativa_cancelamento' => $motivo,
            ]);
    }
}