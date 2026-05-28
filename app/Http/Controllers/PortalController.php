<?php

namespace App\Http\Controllers;

use App\Models\Atleta;
use App\Models\Evento;
use App\Models\Inscricoes;
use App\Models\Resultado;
use App\Models\Modalidade;
use Illuminate\Support\Facades\DB; // Necessário para agrupar os status

class PortalController extends Controller
{
    public function index()
    {
        
        $atletasPorModalidade = Modalidade::withCount('atletas')->get();

        $statusTemporada = Evento::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $topAtletas = Atleta::withCount('inscricoes')
            ->orderBy('inscricoes_count', 'desc')
            ->take(5)
            ->get();

        $proximosEventos = Evento::where('data_inicio', '>=', now())
            ->where('status', '!=', 'Cancelado')
            ->orderBy('data_inicio', 'asc')
            ->take(4)
            ->get();

        $totalAtletas = Atleta::count();
        $totalInscricoes = Inscricoes::count();
        $eventosAtivos = Evento::where('status', '!=', 'Cancelado')->count();
        
        $ultimosResultados = Resultado::with(['evento', 'inscricao.atleta', 'inscricao.time'])
            ->latest()
            ->limit(5)
            ->get();

        return view('portal.index', compact(
            'atletasPorModalidade',
            'statusTemporada',
            'topAtletas',
            'proximosEventos',
            'totalAtletas',
            'totalInscricoes',
            'eventosAtivos',
            'ultimosResultados'
        ));
    }
}