<x-layouts.app>

    <style>
        .hover-scale-up {
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease;
        }

        .hover-scale-up:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.15) !important;
        }

        [data-theme="dark"] .hover-scale-up:hover {
            box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.5) !important;
        }

        /* Linha do tempo elegante */
        .timeline-container {
            border-left: 2px solid var(--cor-borda);
            padding-left: 1.5rem;
            margin-left: 1rem;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-marker {
            position: absolute;
            left: -1.5rem;
            transform: translateX(-50%);
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background-color: var(--cor-primaria);
            border: 3px solid var(--bg-cards);
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        }

        /* Animação de entrada suave */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-up {
            animation: fadeUp 0.6s ease forwards;
        }

        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.2s;
        }
    </style>

    <div class="d-flex align-items-center justify-content-between mb-5 ps-5 ps-md-0 pt-2 pt-md-0 animate-fade-up">
        <div>
            <h2 class="titulo-marca mb-0 fw-bold" style="font-size: 2.2rem;">Visão Geral</h2>
            <div class="text-secondary mt-1">Bem-vindo de volta! Aqui está o resumo operacional de hoje.</div>
        </div>
        <div class="text-end d-none d-md-block bg-light px-4 py-2 rounded-4 border"
            style="border-color: var(--cor-borda) !important;">
            <div class="fw-bold titulo-marca fs-6">{{ now()->translatedFormat('d \d\e F, Y') }}</div>
            <div class="text-primary small fw-semibold d-flex align-items-center gap-2 justify-content-end">
                <i class="bi bi-clock-history"></i> <span id="relogio"></span>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5 animate-fade-up delay-1">
        <div class="col-6 col-md-3">
            <a href="/reservas" class="text-decoration-none">
                <div
                    class="card-premium h-100 p-4 text-center hover-scale-up border-0 shadow-sm rounded-4 d-flex flex-column align-items-center justify-content-center">
                    <div class="icon-card icon-primary mb-3"
                        style="width: 55px; height: 55px;">
                        <i class="bi bi-calendar-plus fs-3"></i>
                    </div>
                    <div class="fw-bold titulo-marca text-dark">Nova Reserva</div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-3">
            <a href="/atletas" class="text-decoration-none">
                <div
                    class="card-premium h-100 p-4 text-center hover-scale-up border-0 shadow-sm rounded-4 d-flex flex-column align-items-center justify-content-center">
                    <div class="icon-card icon-success mb-3"
                        style="width: 55px; height: 55px;">
                        <i class="bi bi-person-plus fs-3"></i>
                    </div>
                    <div class="fw-bold titulo-marca text-dark">Novo Atleta</div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-3">
            <a href="/times" class="text-decoration-none">
                <div
                    class="card-premium h-100 p-4 text-center hover-scale-up border-0 shadow-sm rounded-4 d-flex flex-column align-items-center justify-content-center">
                    <div class="icon-card icon-warning mb-3"
                        style="width: 55px; height: 55px;">
                        <i class="bi bi-shield-plus fs-3"></i>
                    </div>
                    <div class="fw-bold titulo-marca text-dark">Nova Equipe</div>
                </div>
            </a>
        </div>

        <div class="col-6 col-md-3">
            <a href="/inscricoes" class="text-decoration-none">
                <div
                    class="card-premium h-100 p-4 text-center hover-scale-up border-0 shadow-sm rounded-4 d-flex flex-column align-items-center justify-content-center">
                    <div class="icon-card icon-info mb-3"
                        style="width: 55px; height: 55px;">
                        <i class="bi bi-award fs-3"></i>
                    </div>
                    <div class="fw-bold titulo-marca text-dark">Lançar Inscrição</div>
                </div>
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4 animate-fade-up delay-2">

        <div class="col-12 col-xl-7">
            <div class="card-premium p-4 border-0 shadow-sm h-100 rounded-4">
                <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom"
                    style="border-color: var(--cor-borda) !important;">
                    <h5 class="titulo-marca mb-0 fw-bold">Agenda de Hoje</h5>
                    <a href="/reservas" class="btn btn-sm btn-light fw-medium">Ver Grade Completa</a>
                </div>

                <div class="timeline-container mt-2">

                    @forelse($agendaHoje as $reserva)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>

                            <div class="p-3 rounded-4 border border-primary border-opacity-25 badge-soft-primary"
                                style="background-color: var(--bg-sistema);">

                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="fw-bold text-primary fs-5">
                                            {{ \Carbon\Carbon::parse($reserva->data_hora_inicio)->format('H:i') }}
                                        </span>

                                        <span class="text-secondary small">
                                            às {{ \Carbon\Carbon::parse($reserva->data_hora_fim)->format('H:i') }}
                                        </span>
                                    </div>

                                    <span class="badge bg-primary rounded-pill px-3 shadow-sm">
                                        {{ $reserva->tipo }}
                                    </span>
                                </div>

                                <div class="fw-bold titulo-marca fs-6 mb-1">
                                    {{ $reserva->titulo ?? 'Reserva de Espaço' }}
                                </div>

                                <div class="text-secondary small">
                                    <i class="bi bi-geo-alt text-primary me-1"></i>
                                    {{ $reserva->espaco->nome ?? 'Espaço não definido' }}
                                </div>
                            </div>
                        </div>

                    @empty

                        <div class="text-center py-5">
                            <i class="bi bi-calendar-x text-secondary fs-1"></i>

                            <div class="fw-bold titulo-marca mt-3">
                                Nenhuma atividade hoje
                            </div>

                            <div class="text-secondary small">
                                Não há reservas ou atividades programadas para hoje.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-5">
            <div class="d-flex flex-column gap-4 h-100">

                <div class="card-premium p-4 border-0 shadow-sm rounded-4 position-relative overflow-hidden">
                    <div class="position-absolute top-0 end-0 bg-warning opacity-10"
                        style="width: 100px; height: 100px; border-bottom-left-radius: 100%;"></div>

                    <h6 class="titulo-marca mb-4 fw-bold">Avisos do Sistema</h6>

                    @forelse($avisosInscricoes as $aviso)
                        <div
                            class="d-flex gap-3 mb-3 p-3 rounded-4 bg-warning bg-opacity-10 border border-warning border-opacity-25">

                            <div class="text-warning mt-1">
                                <i class="bi bi-exclamation-circle-fill fs-5"></i>
                            </div>

                            <div>
                                <div class="fw-bold text-dark" style="font-size: 0.95rem;">
                                    Inscrições Encerrando: {{ $aviso->nome }}
                                </div>

                                <div class="text-secondary small mt-1">
                                    Atenção: O prazo acaba dia
                                    {{ \Carbon\Carbon::parse($aviso->inscricao_fim)->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>

                    @empty

                        <div class="text-center py-4">
                            <i class="bi bi-check-circle text-success fs-1"></i>

                            <div class="fw-bold titulo-marca mt-3">
                                Nenhum aviso no momento
                            </div>

                            <div class="text-secondary small">
                                Todas as inscrições estão dentro do prazo.
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="card-premium p-4 border-0 shadow-sm rounded-4 flex-grow-1">
                    <h6 class="titulo-marca mb-4 fw-bold">Atividades Recentes</h6>

                    <div class="d-flex flex-column gap-3">

                        @forelse($atividadesRecentes as $atividade)
                            <div class="d-flex align-items-center gap-3 p-2 rounded-3 hover-bg transition 
                                @if (!$loop->first) border-top @endif"
                                style="border-color: var(--cor-borda) !important;">

                                <div class="bg-{{ $atividade->cor }} bg-opacity-10 text-{{ $atividade->cor }}
                                    rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                    style="width: 40px; height: 40px; font-size: 0.85rem;">

                                    <i class="{{ $atividade->icone }}"></i>
                                </div>

                                <div class="flex-grow-1">
                                    <div class="fw-semibold titulo-marca" style="font-size: 0.9rem;">
                                        {{ $atividade->mensagem }}
                                    </div>

                                    <div class="text-secondary small">
                                        {{ $atividade->data->diffForHumans() }}
                                    </div>
                                </div>
                            </div>

                        @empty

                            <div class="text-center py-5">
                                <i class="bi bi-activity text-secondary fs-1"></i>

                                <div class="fw-bold titulo-marca mt-3">
                                    Nenhuma atividade recente
                                </div>

                                <div class="text-secondary small">
                                    O sistema ainda não registrou movimentações.
                                </div>
                            </div>
                        @endforelse

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const relogioElement = document.getElementById('relogio');
            if (relogioElement) {
                setInterval(() => {
                    const now = new Date();
                    relogioElement.innerText = now.toLocaleTimeString('pt-BR', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }, 1000);
            }
        });
    </script>
</x-layouts.app>
