<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Inscricoes;
use App\Models\Time;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTimes = Time::count();
        $eventosSemResultados = Evento::doesntHave('resultados')->count();
        $eventosProximos = Evento::whereBetween('data_inicio', [now()->addDays(7), now()->addDays(15)])->get();

        $agendaHoje = collect([]);

        $avisosInscricoes = Evento::where('status', '!=', 'Cancelado')
            ->whereBetween('inscricao_fim', [now()->startOfDay(), now()->addDays(3)->endOfDay()])
            ->get();

        $ultimosTimes = Time::latest()->take(3)->get();
        $ultimasInscricoes = Inscricoes::with(['atleta', 'time', 'evento'])->latest()->take(3)->get();

        $atividadesRecentes = collect();

        foreach ($ultimosTimes as $time) {
            $atividadesRecentes->push((object) [
                'tipo' => 'Novo Time',
                'mensagem' => "A equipe '{$time->nome}' foi registrada no sistema.",
                'data' => $time->created_at,
                'icone' => 'bi-shield-fill',
                'cor' => 'text-primary',
            ]);
        }

        foreach ($ultimasInscricoes as $inscricao) {
            $nomeInscrito = $inscricao->tipo === 'atleta' 
                ? ($inscricao->atleta?->nome ?? 'Atleta Excluído/Não Encontrado') 
                : ($inscricao->time?->nome ?? 'Time Excluído/Não Encontrado');
            
            $nomeEvento = $inscricao->evento?->nome ?? 'Evento Excluído';

            $atividadesRecentes->push((object) [
                'tipo' => 'Nova Inscrição',
                'mensagem' => "{$nomeInscrito} registrou inscrição no evento '{$nomeEvento}'.",
                'data' => $inscricao->created_at,
                'icone' => 'bi-person-lines-fill',
                'cor' => 'text-success',
            ]);
        }

        $atividadesRecentes = $atividadesRecentes->sortByDesc('data')->take(5);

        return view('dashboard.index', compact(
            'totalTimes',
            'eventosSemResultados',
            'eventosProximos',
            'agendaHoje',
            'avisosInscricoes',
            'atividadesRecentes'
        ));
    }
}
