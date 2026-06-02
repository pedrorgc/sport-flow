<x-layouts.app>
    <style>
        .calendar-wrapper {
            overflow-x: auto;
            border: 1px solid var(--cor-borda);
            border-radius: 0.75rem;
            background: var(--bg-cards);
        }

        .calendar-grid {
            display: flex;
            min-width: 800px;
        }

        .time-col {
            width: 70px;
            flex-shrink: 0;
            border-right: 1px solid var(--cor-borda);
            background-color: var(--cor-hover);
        }

        .day-col {
            flex: 1;
            border-right: 1px solid var(--cor-borda);
            position: relative;
        }

        .day-col:last-child {
            border-right: none;
        }

        /* Cabeçalho com altura fixa para não ser sobreposto */
        .day-header {
            text-align: center;
            padding: 10px 5px;
            border-bottom: 2px solid var(--cor-borda);
            font-weight: 600;
            font-size: 13px;
            color: var(--cor-texto-titulo);
            background-color: var(--bg-sistema);
            height: 57px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            line-height: 1.3;
            position: sticky;
            top: 0;
            z-index: 5;
        }

        .day-header.today {
            color: var(--cor-primaria);
            border-bottom-color: var(--cor-primaria);
        }

        .day-header .day-number {
            font-size: 18px;
            font-weight: 700;
            line-height: 1;
        }

        .day-header.today .day-number {
            background: var(--cor-primaria);
            color: #fff;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            margin: 2px auto 0;
        }

        /* Placeholder do header na coluna de horários */
        .time-header {
            height: 57px;
            border-bottom: 2px solid var(--cor-borda);
            background-color: var(--bg-sistema);
        }

        /* Cada hora = 60px */
        .time-slot {
            height: 60px;
            border-bottom: 1px dashed var(--cor-borda);
            position: relative;
        }

        .time-label {
            font-size: 0.7rem;
            color: var(--cor-texto-corpo);
            text-align: center;
            position: absolute;
            top: -8px;
            width: 100%;
            font-weight: 500;
        }

        /* Blocos de evento posicionados via JS */
        .event-block {
            position: absolute;
            left: 4px;
            right: 4px;
            border-radius: 6px;
            padding: 5px 7px;
            font-size: 0.72rem;
            line-height: 1.25;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .12);
        }

        .event-block:hover {
            transform: scale(1.025);
            z-index: 10;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
        }

        /* Grade Fixa — listras com contraste adequado */
        .event-fixed {
            background: repeating-linear-gradient(45deg,
                    #dde3ef,
                    #dde3ef 8px,
                    #eef1f7 8px,
                    #eef1f7 16px);
            border: 1.5px solid #8fa3c8;
            color: #1e3a5f;
        }

        .event-fixed .event-title {
            font-weight: 700;
            font-size: 0.7rem;
        }

        .event-fixed .event-time {
            font-size: 0.68rem;
            color: #2d5084;
            opacity: .9;
        }

        /* Reserva Avulsa */
        .event-avulsa {
            background-color: var(--cor-primaria);
            color: #ffffff;
            border: 1px solid rgba(0, 0, 0, .1);
        }

        .event-avulsa .event-title {
            font-weight: 700;
            font-size: 0.7rem;
        }

        .event-avulsa .event-time {
            font-size: 0.68rem;
            opacity: .85;
        }

        /* reserva oficial */
        .event-oficial {
            background-color: #dc3545;
            color: #ffffff;
            border: 1px solid rgba(0, 0, 0, .1);
        }

        .event-oficial .event-title {
            font-weight: 700;
            font-size: 0.7rem;
        }

        .event-oficial .event-time {
            font-size: 0.68rem;
            opacity: .85;
        }
    </style>

    <div x-data="{ openModal: false, view: 'list', tipoReserva: 'Avulsa' }" class="w-100">

        <div class="d-flex align-items-center justify-content-between mb-4 ps-5 ps-md-0 pt-2 pt-md-0">
            <div>
                <h2 class="titulo-marca mb-0" style="font-size: 2.2rem;">Agenda de Reservas</h2>
                <div class="text-secondary small mt-1">Gerencie os horários agendados nos espaços</div>
            </div>
            <button class="btn btn-premium d-flex align-items-center gap-2 shadow-sm" @click="openModal = true">
                <i class="bi bi-plus-lg"></i>
                <span class="d-none d-md-inline">Nova Reserva</span>
            </button>
        </div>

        <div class="card-premium mb-4 py-3">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-filter text-muted fs-5"></i>
                    <select class="form-select bg-light border-0 shadow-none w-auto" style="min-width: 250px;">
                        <option>Espaço: teste (Piscina)</option>
                        <option>Espaço: Ginásio Principal</option>
                    </select>
                </div>
                <div class="btn-group bg-light p-1 rounded-3 border" style="border-color: var(--cor-borda) !important;">
                    <button @click="view = 'list'"
                        class="btn btn-sm px-3 rounded-2 fw-medium d-flex align-items-center gap-2"
                        :class="view === 'list' ? 'btn-premium' : 'text-secondary border-0'">
                        <i class="bi bi-list-ul"></i> Lista
                    </button>
                    <button @click="view = 'grid'"
                        class="btn btn-sm px-3 rounded-2 fw-medium d-flex align-items-center gap-2"
                        :class="view === 'grid' ? 'btn-premium' : 'text-secondary border-0'">
                        <i class="bi bi-calendar-week"></i> Grade
                    </button>
                </div>
            </div>
        </div>

        {{-- VIEW: Lista --}}
        <div x-show="view === 'list'" x-transition.opacity class="card-premium p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase" style="letter-spacing: 0.5px;">
                            <th class="ps-4 py-3 border-bottom-0">Espaço</th>
                            <th class="py-3 border-bottom-0">Data / Horário</th>
                            <th class="py-3 border-bottom-0">Finalidade & Solicitante</th>
                            <th class="py-3 border-bottom-0">Status</th>
                            <th class="text-end pe-4 py-3 border-bottom-0">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($reservas as $reserva)
                            <tr>
                                <td class="ps-4 py-3 fw-medium titulo-marca">
                                    <i class="bi bi-geo-alt text-primary me-1"></i>
                                    {{ $reserva->espaco->nome ?? '---' }}
                                </td>
                                <td class="py-3">
                                    <div class="titulo-marca fw-medium">
                                        {{ \Carbon\Carbon::parse($reserva->data_hora_inicio)->format('d/m/Y') }}</div>
                                    <div class="text-secondary small">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($reserva->data_hora_inicio)->format('H:i') }} às
                                        {{ \Carbon\Carbon::parse($reserva->data_hora_fim)->format('H:i') }}
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="titulo-marca">{{ $reserva->tipo }}</div>
                                </td>
                                <td class="py-3">
                                    <span
                                        class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2 fw-medium border border-success border-opacity-25">
                                        {{ $reserva->status }}
                                    </span>
                                </td>
                                <td class="text-end pe-4 py-3">
                                    <button class="btn btn-sm btn-light text-danger" title="Cancelar Reserva"
                                        @click="$dispatch('confirmar-exclusao', {
                                        action: '{{ route('reservas.destroy', $reserva->id) }}',
                                        mensagem: 'Tem certeza que deseja cancelar esta reserva?'
                                    })">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-secondary">
                                    <i class="bi bi-calendar-x fs-1 d-block mb-3 opacity-50"></i>
                                    Nenhuma reserva cadastrada ainda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- VIEW: Grade --}}
        <div x-show="view === 'grid'" x-cloak x-transition.opacity class="calendar-wrapper shadow-sm">

            <div class="d-flex align-items-center justify-content-between p-3 border-bottom"
                style="border-color: var(--cor-borda) !important; background-color: var(--bg-sistema);">
                <button class="btn btn-sm btn-light"><i class="bi bi-chevron-left"></i></button>
                <h5 class="titulo-marca mb-0 fw-bold">13 a 19 de Abril, 2026</h5>
                <button class="btn btn-sm btn-light"><i class="bi bi-chevron-right"></i></button>
            </div>

            <div class="calendar-grid">

                {{-- Coluna de horários --}}
                <div class="time-col">
                    <div class="time-header"></div>
                    @for ($i = 8; $i <= 22; $i++)
                        <div class="time-slot">
                            <span class="time-label">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00</span>
                        </div>
                    @endfor
                </div>

                {{-- SEG 13/04 — hoje --}}
                <div class="day-col">
                    <div class="day-header today">
                        <span>Seg</span>
                        <span class="day-number">13</span>
                    </div>
                    @for ($i = 8; $i <= 22; $i++)
                        <div class="time-slot"></div>
                    @endfor
                    <div class="event-block event-fixed" id="ev-seg-natacao">
                        <div class="event-title"><i class="bi bi-arrow-repeat me-1"></i>Natação Livre</div>
                        <div class="event-time">08:00 – 09:30</div>
                    </div>
                </div>

                {{-- TER 14/04 --}}
                <div class="day-col">
                    <div class="day-header">
                        <span>Ter</span>
                        <span class="day-number">14</span>
                    </div>
                    @for ($i = 8; $i <= 22; $i++)
                        <div class="time-slot"></div>
                    @endfor
                    <div class="event-block event-fixed" id="ev-ter-basquete">
                        <div class="event-title"><i class="bi bi-arrow-repeat me-1"></i>Basquete Sub-12</div>
                        <div class="event-time">14:00 – 16:00</div>
                    </div>
                </div>

                {{-- QUA 15/04 --}}
                <div class="day-col">
                    <div class="day-header">
                        <span>Qua</span>
                        <span class="day-number">15</span>
                    </div>
                    @for ($i = 8; $i <= 22; $i++)
                        <div class="time-slot"></div>
                    @endfor
                    <div class="event-block event-fixed" id="ev-qua-natacao">
                        <div class="event-title"><i class="bi bi-arrow-repeat me-1"></i>Natação Livre</div>
                        <div class="event-time">08:00 – 09:30</div>
                    </div>
                    <div class="event-block event-avulsa" id="ev-qua-joao" @click="openModal = true">
                        <div class="event-title">Aluguel — João</div>
                        <div class="event-time"><i class="bi bi-clock me-1"></i>19:00 – 21:00</div>
                        <div style="font-size:.65rem;margin-top:3px;opacity:.85;"><i
                                class="bi bi-check-circle me-1"></i>Confirmado</div>
                    </div>
                </div>

                {{-- QUI 16/04 --}}
                <div class="day-col">
                    <div class="day-header">
                        <span>Qui</span>
                        <span class="day-number">16</span>
                    </div>
                    @for ($i = 8; $i <= 22; $i++)
                        <div class="time-slot"></div>
                    @endfor
                    <div class="event-block event-fixed" id="ev-qui-basquete">
                        <div class="event-title"><i class="bi bi-arrow-repeat me-1"></i>Basquete Sub-12</div>
                        <div class="event-time">14:00 – 16:00</div>
                    </div>
                </div>

                {{-- SEX 17/04 --}}
                <div class="day-col">
                    <div class="day-header">
                        <span>Sex</span>
                        <span class="day-number">17</span>
                    </div>
                    @for ($i = 8; $i <= 22; $i++)
                        <div class="time-slot"></div>
                    @endfor
                    <div class="event-block event-fixed" id="ev-sex-natacao">
                        <div class="event-title"><i class="bi bi-arrow-repeat me-1"></i>Natação Livre</div>
                        <div class="event-time">08:00 – 09:30</div>
                    </div>
                </div>

            </div>

            <div class="d-flex gap-4 p-3 border-top bg-light" style="border-color: var(--cor-borda) !important;">
                <div class="d-flex align-items-center gap-2 small text-secondary">
                    <div
                        style="width:15px;height:15px;border-radius:3px;background:repeating-linear-gradient(45deg,#dde3ef,#dde3ef 4px,#eef1f7 4px,#eef1f7 8px);border:1.5px solid #8fa3c8;">
                    </div>
                    Grade Fixa / Rotina
                </div>
                <div class="d-flex align-items-center gap-2 small text-secondary">
                    <div style="width:15px;height:15px;border-radius:3px;background:var(--cor-primaria);"></div>
                    Reservas Avulsas
                </div>
            </div>

        </div>

        <div x-show="openModal" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background:rgba(15,23,42,.6);backdrop-filter:blur(2px);z-index:2000;" x-transition.opacity
            @click.self="openModal = false">
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width:650px;" x-show="openModal"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0">Nova Reserva</h4>
                        <button
                            class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width:35px;height:35px;" @click="openModal = false">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('reservas.store') }}" class="p-4">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-secondary">Espaço <span
                                        class="text-danger">*</span></label>
                                <select name="espaco_id" class="form-select bg-light" required>
                                    <option value="">Selecionar espaço...</option>
                                    @foreach ($espacos as $espaco)
                                        <option value="{{ $espaco->id }}">{{ $espaco->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-secondary">Tipo de Reserva <span
                                        class="text-danger">*</span></label>
                                <select name="tipo" class="form-select bg-light" x-model="tipoReserva" required>
                                    <option value="Avulsa">Avulsa (Único dia)</option>
                                    <option value="Fixa">Fixa (Rotina contínua)</option>
                                    <option value="Oficial">Evento Oficial (Prioridade)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 p-3 bg-danger bg-opacity-10 border border-danger border-opacity-25 rounded-3"
                            x-show="tipoReserva === 'Oficial'" x-cloak>
                            <label class="form-label fw-semibold text-danger small">Vincular a Campeonato Oficial <span
                                    class="text-danger">*</span></label>
                            <select name="evento_id" class="form-select bg-white">
                                <option value="">Qual o evento?</option>
                                @foreach ($eventos as $evento)
                                    <option value="{{ $evento->id }}">{{ $evento->nome }}</option>
                                @endforeach
                            </select>
                            <div class="form-text text-danger opacity-75" style="font-size: 0.7rem;">Esta reserva
                                cancelará atividades comuns no mesmo horário.</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Início <span
                                        class="text-danger">*</span></label>
                                <input type="datetime-local" name="data_hora_inicio" class="form-control bg-light"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Fim <span
                                        class="text-danger">*</span></label>
                                <input type="datetime-local" name="data_hora_fim" class="form-control bg-light"
                                    required>
                            </div>
                        </div>

                        <div class="mb-3 p-3 bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-3"
                            x-show="tipoReserva === 'Fixa'" x-cloak>
                            <label class="form-label fw-semibold text-primary small">Repetir semanalmente até: <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="data_limite_repeticao" class="form-control bg-white">
                            <div class="form-text text-primary opacity-75" style="font-size: 0.7rem;">Máximo de 6
                                meses de repetição.</div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-light fw-medium"
                                @click="openModal = false">Cancelar</button>
                            <button type="submit" class="btn btn-premium px-4">Confirmar Reserva</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    {{-- Script de posicionamento dos eventos --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const SLOT_HEIGHT = 60;
            const START_HOUR = 8;

            async function carregarReservas() {
                try {
                    const response = await fetch('/api/reservas-mensais');
                    const reservas = await response.json();

                    const grid = document.querySelector('.calendar-grid');
                    if (!grid) return;

                    reservas.forEach(reserva => {
                        const inicio = new Date(reserva.start);
                        const fim = new Date(reserva.end);

                        const diaSemana = inicio.getDay(); // 0=Dom, 1=Seg...
                        const colunas = grid.querySelectorAll('.day-col');

                        // Encontra a coluna do dia correspondente
                        const coluna = colunas[diaSemana === 0 ? 6 : diaSemana - 1];
                        if (!coluna) return;

                        const startH = inicio.getHours();
                        const startM = inicio.getMinutes();
                        const endH = fim.getHours();
                        const endM = fim.getMinutes();

                        const top = (startH - START_HOUR + startM / 60) * SLOT_HEIGHT;
                        const height = Math.max((endH - startH + (endM - startM) / 60) * SLOT_HEIGHT,
                            24);

                        // Define a classe de cor pelo tipo
                        const corClasse = {
                            'Oficial': 'event-oficial',
                            'Fixa': 'event-fixed',
                            'Avulsa': 'event-avulsa'
                        } [reserva.extendedProps.tipo] || 'event-avulsa';

                        const bloco = document.createElement('div');
                        bloco.className = `event-block ${corClasse}`;
                        bloco.style.top = top + 'px';
                        bloco.style.height = height + 'px';
                        bloco.innerHTML = `
                    <div class="event-title">${reserva.title}</div>
                    <div class="event-time">${inicio.getHours().toString().padStart(2,'0')}:${inicio.getMinutes().toString().padStart(2,'0')} – ${fim.getHours().toString().padStart(2,'0')}:${fim.getMinutes().toString().padStart(2,'0')}</div>
                `;

                        coluna.appendChild(bloco);
                    });

                } catch (error) {
                    console.error('Erro ao carregar reservas:', error);
                }
            }

            carregarReservas();
        });
    </script>
</x-layouts.app>
