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
        .day-col:last-child { border-right: none; }

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
            box-shadow: 0 1px 3px rgba(0,0,0,.12);
        }
        .event-block:hover { transform: scale(1.025); z-index: 10; box-shadow: 0 4px 12px rgba(0,0,0,.15); }

        /* Grade Fixa — listras com contraste adequado */
        .event-fixed {
            background: repeating-linear-gradient(
                45deg,
                #dde3ef,
                #dde3ef 8px,
                #eef1f7 8px,
                #eef1f7 16px
            );
            border: 1.5px solid #8fa3c8;
            color: #1e3a5f;
        }
        .event-fixed .event-title { font-weight: 700; font-size: 0.7rem; }
        .event-fixed .event-time  { font-size: 0.68rem; color: #2d5084; opacity: .9; }

        /* Reserva Avulsa */
        .event-avulsa {
            background-color: var(--cor-primaria);
            color: #ffffff;
            border: 1px solid rgba(0,0,0,.1);
        }
        .event-avulsa .event-title { font-weight: 700; font-size: 0.7rem; }
        .event-avulsa .event-time  { font-size: 0.68rem; opacity: .85; }
    </style>

    <div x-data="{ openModal: false, view: 'list' }" class="w-100">

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
                    <button @click="view = 'list'" class="btn btn-sm px-3 rounded-2 fw-medium d-flex align-items-center gap-2"
                        :class="view === 'list' ? 'btn-premium' : 'text-secondary border-0'">
                        <i class="bi bi-list-ul"></i> Lista
                    </button>
                    <button @click="view = 'grid'" class="btn btn-sm px-3 rounded-2 fw-medium d-flex align-items-center gap-2"
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
                        <tr>
                            <td class="ps-4 py-3 fw-medium titulo-marca">
                                <i class="bi bi-geo-alt text-primary me-1"></i> teste
                            </td>
                            <td class="py-3">
                                <div class="titulo-marca fw-medium">21/03/2026</div>
                                <div class="text-secondary small"><i class="bi bi-clock me-1"></i> 12:00 às 23:00</div>
                            </td>
                            <td class="py-3">
                                <div class="titulo-marca">boiar</div>
                                <div class="text-secondary small"><i class="bi bi-person me-1"></i> eu mesmo aqui</div>
                            </td>
                            <td class="py-3">
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2 fw-medium border border-success border-opacity-25">Confirmada</span>
                            </td>
                            <td class="text-end pe-4 py-3">
                                <button class="btn btn-sm btn-light text-danger" title="Cancelar Reserva"><i class="bi bi-trash3"></i></button>
                            </td>
                        </tr>
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
                    @for ($i = 8; $i <= 22; $i++) <div class="time-slot"></div> @endfor
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
                    @for ($i = 8; $i <= 22; $i++) <div class="time-slot"></div> @endfor
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
                    @for ($i = 8; $i <= 22; $i++) <div class="time-slot"></div> @endfor
                    <div class="event-block event-fixed" id="ev-qua-natacao">
                        <div class="event-title"><i class="bi bi-arrow-repeat me-1"></i>Natação Livre</div>
                        <div class="event-time">08:00 – 09:30</div>
                    </div>
                    <div class="event-block event-avulsa" id="ev-qua-joao" @click="openModal = true">
                        <div class="event-title">Aluguel — João</div>
                        <div class="event-time"><i class="bi bi-clock me-1"></i>19:00 – 21:00</div>
                        <div style="font-size:.65rem;margin-top:3px;opacity:.85;"><i class="bi bi-check-circle me-1"></i>Confirmado</div>
                    </div>
                </div>

                {{-- QUI 16/04 --}}
                <div class="day-col">
                    <div class="day-header">
                        <span>Qui</span>
                        <span class="day-number">16</span>
                    </div>
                    @for ($i = 8; $i <= 22; $i++) <div class="time-slot"></div> @endfor
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
                    @for ($i = 8; $i <= 22; $i++) <div class="time-slot"></div> @endfor
                    <div class="event-block event-fixed" id="ev-sex-natacao">
                        <div class="event-title"><i class="bi bi-arrow-repeat me-1"></i>Natação Livre</div>
                        <div class="event-time">08:00 – 09:30</div>
                    </div>
                </div>

            </div>

            <div class="d-flex gap-4 p-3 border-top bg-light" style="border-color: var(--cor-borda) !important;">
                <div class="d-flex align-items-center gap-2 small text-secondary">
                    <div style="width:15px;height:15px;border-radius:3px;background:repeating-linear-gradient(45deg,#dde3ef,#dde3ef 4px,#eef1f7 4px,#eef1f7 8px);border:1.5px solid #8fa3c8;"></div>
                    Grade Fixa / Rotina
                </div>
                <div class="d-flex align-items-center gap-2 small text-secondary">
                    <div style="width:15px;height:15px;border-radius:3px;background:var(--cor-primaria);"></div>
                    Reservas Avulsas
                </div>
            </div>

        </div>

        <div x-show="openModal" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background:rgba(15,23,42,.6);backdrop-filter:blur(2px);z-index:2000;"
            x-transition.opacity @click.self="openModal = false">
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width:650px;"
                     x-show="openModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0">Nova Reserva</h4>
                        <button class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width:35px;height:35px;" @click="openModal = false">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <form class="p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Espaço Desejado <span class="text-danger">*</span></label>
                            <select class="form-select bg-light">
                                <option>Selecionar espaço cadastrado...</option>
                                <option>teste (Piscina)</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Data <span class="text-danger">*</span></label>
                                <input type="date" class="form-control bg-light">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Hora Inicial <span class="text-danger">*</span></label>
                                <input type="time" class="form-control bg-light">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label fw-semibold small text-secondary">Hora Final <span class="text-danger">*</span></label>
                                <input type="time" class="form-control bg-light">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-semibold small text-secondary">Finalidade <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-light" placeholder="Ex: Treino, Torneio, Lazer">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-secondary">Nome do Solicitante <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-light">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-light fw-medium" @click="openModal = false">Cancelar</button>
                            <button type="button" class="btn btn-premium px-4">Confirmar Reserva</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    {{-- Script de posicionamento dos eventos --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const SLOT_HEIGHT = 60;
            const START_HOUR  = 8;

            function placeEvent(id, startH, startM, endH, endM) {
                const el = document.getElementById(id);
                if (!el) return;
                const top    = (startH - START_HOUR + startM / 60) * SLOT_HEIGHT;
                const height = (endH - startH + (endM - startM) / 60) * SLOT_HEIGHT;
                el.style.top    = top + 'px';
                el.style.height = Math.max(height, 24) + 'px';
            }

            placeEvent('ev-seg-natacao',   8,  0,  9, 30);
            placeEvent('ev-ter-basquete', 14,  0, 16,  0);
            placeEvent('ev-qua-natacao',   8,  0,  9, 30);
            placeEvent('ev-qua-joao',     19,  0, 21,  0);
            placeEvent('ev-qui-basquete', 14,  0, 16,  0);
            placeEvent('ev-sex-natacao',   8,  0,  9, 30);
        });
    </script>
</x-layouts.app>