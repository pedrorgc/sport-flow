<x-layouts.app>
    <style>
        .calendar-wrapper { overflow-x: auto; border: 1px solid var(--cor-borda); border-radius: 0.75rem; background: var(--bg-cards); }
        .calendar-grid { display: flex; min-width: 800px; }
        .time-col { width: 70px; flex-shrink: 0; border-right: 1px solid var(--cor-borda); background-color: var(--cor-hover); }
        .day-col { flex: 1; border-right: 1px solid var(--cor-borda); position: relative; }
        .day-col:last-child { border-right: none; }
        .day-header { text-align: center; padding: 10px 5px; border-bottom: 2px solid var(--cor-borda); font-weight: 600; font-size: 13px; color: var(--cor-texto-titulo); background-color: var(--bg-sistema); height: 57px; display: flex; flex-direction: column; align-items: center; justify-content: center; line-height: 1.3; position: sticky; top: 0; z-index: 5; }
        .day-header.today { color: var(--cor-primaria); border-bottom-color: var(--cor-primaria); }
        .day-header .day-number { font-size: 18px; font-weight: 700; line-height: 1; }
        .day-header.today .day-number { background: var(--cor-primaria); color: #fff; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; font-size: 14px; margin: 2px auto 0; }
        .time-header { height: 57px; border-bottom: 2px solid var(--cor-borda); background-color: var(--bg-sistema); }
        .time-slot { height: 60px; border-bottom: 1px dashed var(--cor-borda); position: relative; }
        .time-label { font-size: 0.7rem; color: var(--cor-texto-corpo); text-align: center; position: absolute; top: -8px; width: 100%; font-weight: 500; }
        
        .event-block { position: absolute; left: 4px; right: 4px; border-radius: 6px; padding: 5px 7px; font-size: 0.72rem; line-height: 1.25; overflow: hidden; cursor: pointer; transition: transform 0.15s, box-shadow 0.15s; box-shadow: 0 1px 3px rgba(0, 0, 0, .12); z-index: 10; display: flex; flex-direction: column; }
        .event-block:hover { transform: scale(1.025); z-index: 20; box-shadow: 0 4px 12px rgba(0, 0, 0, .15); }
        
        .event-fixed { background: repeating-linear-gradient(45deg, #dde3ef, #dde3ef 8px, #eef1f7 8px, #eef1f7 16px); border: 1.5px solid #8fa3c8; color: #1e3a5f; }
        .event-fixed .event-title { font-weight: 700; font-size: 0.7rem; }
        
        .event-avulsa { background-color: var(--cor-primaria); color: #ffffff; border: 1px solid rgba(0, 0, 0, .1); }
        .event-avulsa .event-title { font-weight: 700; font-size: 0.7rem; }
        
        .event-oficial { background-color: #dc3545; color: #ffffff; border: 1px solid rgba(0, 0, 0, .1); }
        .event-oficial .event-title { font-weight: 700; font-size: 0.7rem; }
    </style>

    <div x-data="{ 
            openModal: false, 
            modalVisualizar: false, 
            view: 'grid', 
            tipoReserva: 'Avulsa',
            reservaSelecionada: {} 
        }" 
        @abrir-modal-detalhes.window="reservaSelecionada = $event.detail; modalVisualizar = true"
        @fechar-modal-formulario.window="openModal = false"
        class="w-100">

        <div class="d-flex align-items-center justify-content-between mb-4 ps-5 ps-md-0 pt-2 pt-md-0">
            <div>
                <h2 class="titulo-marca mb-0" style="font-size: 2.2rem;">Agenda de Reservas</h2>
                <div class="text-secondary small mt-1">Gerencie os horários agendados nos espaços</div>
            </div>
            <button class="btn btn-premium d-flex align-items-center gap-2 shadow-sm" onclick="prepararNovaReserva()" @click="openModal = true">
                <i class="bi bi-plus-lg"></i>
                <span class="d-none d-md-inline">Nova Reserva</span>
            </button>
        </div>

        <div id="containerAlertasGerais"></div>

        <div class="card-premium mb-4 py-3">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <i class="bi bi-filter text-muted fs-5"></i>
                    <select id="filtroEspaco" class="form-select bg-light border-0 shadow-none w-auto" style="min-width: 250px;" onchange="window.recarregarCalendario()">
                        <option value="">Todos os Espaços</option>
                        @foreach ($espacos as $espaco)
                            <option value="{{ $espaco->id }}">{{ $espaco->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="btn-group bg-light p-1 rounded-3 border" style="border-color: var(--cor-borda) !important;">
                    <button @click="view = 'list'" class="btn btn-sm px-3 rounded-2 fw-medium d-flex align-items-center gap-2" :class="view === 'list' ? 'btn-premium' : 'text-secondary border-0'">
                        <i class="bi bi-list-ul"></i> Lista
                    </button>
                    <button @click="view = 'grid'" class="btn btn-sm px-3 rounded-2 fw-medium d-flex align-items-center gap-2" :class="view === 'grid' ? 'btn-premium' : 'text-secondary border-0'">
                        <i class="bi bi-calendar-week"></i> Grade
                    </button>
                </div>
            </div>
        </div>

        {{-- VIEW: LISTA --}}
        <div x-show="view === 'list'" x-transition.opacity class="card-premium p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase" style="letter-spacing: 0.5px;">
                            <th class="ps-4 py-3 border-bottom-0">Reserva / Espaço</th>
                            <th class="py-3 border-bottom-0">Data / Horário</th>
                            <th class="py-3 border-bottom-0">Tipo</th>
                            <th class="py-3 border-bottom-0">Status</th>
                            <th class="text-end pe-4 py-3 border-bottom-0">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($reservas as $reserva)
                            <tr>
                                <td class="ps-4 py-3 fw-medium titulo-marca">
                                    <span class="text-dark d-block fw-bold">{{ $reserva->titulo }}</span>
                                    <small class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $reserva->espaco->nome ?? '---' }}</small>
                                </td>
                                <td class="py-3">
                                    <div class="titulo-marca fw-medium">{{ \Carbon\Carbon::parse($reserva->data_hora_inicio)->format('d/m/Y') }}</div>
                                    <div class="text-secondary small"><i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($reserva->data_hora_inicio)->format('H:i') }} às {{ \Carbon\Carbon::parse($reserva->data_hora_fim)->format('H:i') }}</div>
                                </td>
                                <td class="py-3"><div class="titulo-marca fw-bold">{{ $reserva->tipo }}</div></td>
                                <td class="py-3">
                                    @php $corStatus = $reserva->status === 'Confirmada' ? 'success' : ($reserva->status === 'Cancelada' ? 'danger' : 'warning'); @endphp
                                    <span class="badge rounded-pill bg-{{ $corStatus }} bg-opacity-10 text-{{ $corStatus }} px-3 py-2 fw-medium border border-{{ $corStatus }} border-opacity-25">
                                        {{ $reserva->status }}
                                    </span>
                                </td>
                                <td class="text-end pe-4 py-3">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-sm btn-light text-primary hover-shadow" onclick="executarEdicaoReserva({{ $reserva->id }})" @click="openModal = true"><i class="bi bi-pencil-square"></i></button>
                                        <button class="btn btn-sm btn-light text-danger hover-shadow" title="Cancelar Reserva"
                                            @click="$dispatch('confirmar-exclusao', {
                                                action: '{{ route('reservas.destroy', $reserva->id) }}',
                                                mensagem: 'Tem certeza que deseja cancelar esta reserva?'
                                            })">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-5 text-secondary"><i class="bi bi-calendar-x fs-1 d-block mb-3 opacity-50"></i> Nenhuma reserva cadastrada ainda.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- VIEW: GRADE --}}
        <div x-show="view === 'grid'" x-cloak x-transition.opacity class="calendar-wrapper shadow-sm">
            <div class="d-flex align-items-center justify-content-between p-3 border-bottom" style="border-color: var(--cor-borda) !important; background-color: var(--bg-sistema);">
                <div class="d-flex gap-2">
                    <a href="{{ route('reservas.index', ['data' => $semanaAnterior]) }}" class="btn btn-sm btn-light shadow-sm"><i class="bi bi-chevron-left"></i></a>
                    <a href="{{ route('reservas.index') }}" class="btn btn-sm btn-light shadow-sm d-none d-md-inline">Hoje</a>
                </div>
                <h5 class="titulo-marca mb-0 fw-bold">{{ $tituloSemana }}</h5>
                <a href="{{ route('reservas.index', ['data' => $proximaSemana]) }}" class="btn btn-sm btn-light shadow-sm"><i class="bi bi-chevron-right"></i></a>
            </div>

            <div class="calendar-grid">
                <div class="time-col">
                    <div class="time-header"></div>
                    @for ($i = 8; $i <= 22; $i++)
                        <div class="time-slot"><span class="time-label">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00</span></div>
                    @endfor
                </div>

                @php $nomesDias = ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom']; @endphp
                @for ($d = 0; $d < 7; $d++)
                    @php
                        $dataColuna = $inicioSemana->copy()->addDays($d);
                        $isHoje = $dataColuna->isToday();
                    @endphp
                    <div class="day-col" data-date="{{ $dataColuna->format('Y-m-d') }}">
                        <div class="day-header {{ $isHoje ? 'today' : '' }}">
                            <span>{{ $nomesDias[$d] }}</span>
                            <span class="day-number">{{ $dataColuna->format('d') }}</span>
                        </div>
                        @for ($h = 8; $h <= 22; $h++)
                            <div class="time-slot"></div>
                        @endfor
                    </div>
                @endfor
            </div>
        </div>

        <div x-show="modalVisualizar" x-cloak class="position-fixed top-0 start-0 w-100 h-100" style="background:rgba(15,23,42,.6);backdrop-filter:blur(2px);z-index:2000;" x-transition.opacity @click.self="modalVisualizar = false">
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width:500px;" x-show="modalVisualizar" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    
                    <div class="p-4 border-bottom d-flex justify-content-between align-items-start">
                        <div>
                            <span class="badge mb-2" :class="{'bg-primary': reservaSelecionada.tipo === 'Fixa', 'bg-success': reservaSelecionada.tipo === 'Avulsa', 'bg-danger': reservaSelecionada.tipo === 'Oficial'}" x-text="reservaSelecionada.tipo"></span>
                            <h4 class="titulo-marca mb-0 fw-bold" x-text="reservaSelecionada.title"></h4>
                        </div>
                        <button class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width:35px;height:35px;" @click="modalVisualizar = false"><i class="bi bi-x-lg"></i></button>
                    </div>

                    <div class="p-4">
                        <div class="mb-3 d-flex align-items-center text-secondary">
                            <i class="bi bi-clock fs-5 text-primary me-3"></i>
                            <div>
                                <div class="fw-bold text-dark" x-text="reservaSelecionada.data"></div>
                                <div class="small" x-text="reservaSelecionada.horario"></div>
                            </div>
                        </div>

                        <div class="mb-3 d-flex align-items-center text-secondary">
                            <i class="bi bi-geo-alt fs-5 text-primary me-3"></i>
                            <div>
                                <div class="fw-bold text-dark">Espaço Físico</div>
                                <div class="small" x-text="reservaSelecionada.espaco"></div>
                            </div>
                        </div>

                        <div class="mb-4 d-flex align-items-center text-secondary">
                            <i class="bi bi-person fs-5 text-primary me-3"></i>
                            <div>
                                <div class="fw-bold text-dark">Responsável</div>
                                <div class="small" x-text="reservaSelecionada.responsavel"></div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3 border-top mt-4">
                            <button class="btn btn-light text-primary border fw-medium" @click="modalVisualizar = false; executarEdicaoReserva(reservaSelecionada.id); openModal = true">
                                <i class="bi bi-pencil-square me-1"></i>Editar
                            </button>

                            <button class="btn btn-danger px-4 shadow-sm"
                                x-text="reservaSelecionada.tipo === 'Fixa' ? 'Cancelar Só Esta' : 'Cancelar Reserva'"
                                @click="$dispatch('confirmar-exclusao', {
                                    action: `/reservas/${reservaSelecionada.id}`,
                                    mensagem: 'Tem certeza que deseja cancelar apenas esta reserva?'
                                })">
                            </button>

                            <template x-if="reservaSelecionada.tipo === 'Fixa'">
                                <button class="btn btn-outline-danger px-3 shadow-sm fw-bold"
                                    @click="$dispatch('confirmar-exclusao', {
                                        action: `/reservas/${reservaSelecionada.id}?cancelar_grupo=1`,
                                        mensagem: 'Isso cancelará toda a rotina futura. Confirmar?'
                                    })">
                                    Cancelar Rotina
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="openModal" x-cloak class="position-fixed top-0 start-0 w-100 h-100" style="background:rgba(15,23,42,.6);backdrop-filter:blur(2px);z-index:2000;" x-transition.opacity @click.self="openModal = false">
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width:650px;" x-show="openModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0" id="tituloModalReserva">Nova Reserva</h4>
                        <button class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width:35px;height:35px;" @click="openModal = false"><i class="bi bi-x-lg"></i></button>
                    </div>
                    
                    <div class="p-4 pb-0 d-none" id="modalErroContainer">
                        <div class="alert alert-danger mb-0 rounded-3 border-0 small" id="modalErroTexto"></div>
                    </div>

                    <form method="POST" action="{{ route('reservas.store') }}" class="p-4" id="formReserva" onsubmit="submeterFormularioAssincrono(event)">
                        @csrf
                        <input type="hidden" name="_method" id="metodoFormReserva" value="POST">

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Título da Atividade <span class="text-danger">*</span></label>
                            <input type="text" name="titulo" id="inputTitulo" class="form-control bg-light" placeholder="Ex: Treino de Basquete Sub-15" required>
                        </div>

                        <div class="mb-3 p-3 bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded-3" id="boxAlterarGrupo" style="display: none;">
                            <label class="form-label fw-semibold text-warning small mb-1"><i class="bi bi-exclamation-triangle-fill"></i> Rotina Recorrente Detectada</label>
                            <select name="alterar_grupo" id="inputAlterarGrupo" class="form-select bg-white">
                                <option value="0">Alterar APENAS este dia específico</option>
                                <option value="1">Alterar este dia e TODAS as repetições futuras</option>
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-secondary">Responsável <span class="text-danger">*</span></label>
                                <select name="responsavel_id" id="inputResponsavel" class="form-select bg-light" required>
                                    <option value="">Quem está reservando?</option>
                                    @foreach ($usuarios as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-secondary">Tipo de Reserva <span class="text-danger">*</span></label>
                                <select name="tipo" id="inputTipo" class="form-select bg-light" x-model="tipoReserva" required>
                                    <option value="Avulsa">Avulsa (Único dia)</option>
                                    <option value="Fixa">Fixa (Rotina contínua)</option>
                                    <option value="Oficial">Evento Oficial (Prioridade)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 p-3 bg-danger bg-opacity-10 border border-danger border-opacity-25 rounded-3" x-show="tipoReserva === 'Oficial'" x-cloak>
                            <label class="form-label fw-semibold text-danger small">Vincular a Campeonato Oficial <span class="text-danger">*</span></label>
                            <select name="evento_id" id="inputEvento" class="form-select bg-white">
                                <option value="">Qual o evento?</option>
                                @foreach ($eventos as $evento)
                                    <option value="{{ $evento->id }}">{{ $evento->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary">Espaço Físico <span class="text-danger">*</span></label>
                            <select name="espaco_id" id="inputEspacoForm" class="form-select bg-light" required>
                                <option value="">Onde será?</option>
                                @foreach ($espacos as $espaco)
                                    <option value="{{ $espaco->id }}">{{ $espaco->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-secondary">Data do Evento / Início da Rotina <span class="text-danger">*</span></label>
                                <input type="date" name="data_reserva" id="inputDataReserva" class="form-control bg-light" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold small text-secondary">Horário Início <span class="text-danger">*</span></label>
                                <input type="time" name="hora_inicio" id="inputHoraInicio" class="form-control bg-light" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold small text-secondary">Horário Fim <span class="text-danger">*</span></label>
                                <input type="time" name="hora_fim" id="inputHoraFim" class="form-control bg-light" required>
                            </div>
                        </div>

                        <div class="mb-3 p-3 bg-light border rounded-3" id="boxDiasSemana" x-show="tipoReserva === 'Fixa'" x-cloak>
                            <label class="form-label fw-semibold small text-dark d-block mb-2">Dias de Repetição Semanal <span class="text-danger">*</span></label>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias_semana[]" value="1" id="checkSeg">
                                    <label class="form-check-label small fw-medium" for="checkSeg">Seg</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias_semana[]" value="2" id="checkTer">
                                    <label class="form-check-label small fw-medium" for="checkTer">Ter</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias_semana[]" value="3" id="checkQua">
                                    <label class="form-check-label small fw-medium" for="checkQua">Qua</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias_semana[]" value="4" id="checkQui">
                                    <label class="form-check-label small fw-medium" for="checkQui">Qui</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias_semana[]" value="5" id="checkSex">
                                    <label class="form-check-label small fw-medium" for="checkSex">Sex</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias_semana[]" value="6" id="checkSab">
                                    <label class="form-check-label small fw-medium" for="checkSab">Sáb</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="dias_semana[]" value="7" id="checkDom">
                                    <label class="form-check-label small fw-medium" for="checkDom">Dom</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 p-3 bg-primary bg-opacity-10 border border-primary border-opacity-25 rounded-3" id="boxDataLimite" x-show="tipoReserva === 'Fixa'" x-cloak>
                            <div class="d-flex align-items-start gap-2 mb-2">
                                <i class="bi bi-arrow-repeat fs-4 text-primary mt-1"></i>
                                <div>
                                    <h6 class="text-primary fw-bold mb-1">Duração da Rotina</h6>
                                    <p class="text-primary opacity-75 mb-0" style="font-size: 0.8rem; line-height: 1.3;">
                                        O sistema criará agendamentos nos dias marcados acima até atingir o limite estipulado:
                                    </p>
                                </div>
                            </div>
                            <input type="date" name="data_limite_repeticao" id="inputDataLimite" class="form-control bg-white">
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-light fw-medium" @click="openModal = false">Cancelar</button>
                            <button type="submit" id="btnSalvarReserva" class="btn btn-premium px-4">Confirmar Reserva</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT CENTRAL MOTOR DO CALENDÁRIO --}}
    <script>
        window.recarregarCalendario = null;

        function prepararNovaReserva() {
            document.getElementById('modalErroContainer').classList.add('d-none');
            const form = document.getElementById('formReserva');
            form.reset();
            form.action = "{{ route('reservas.store') }}";
            document.getElementById('metodoFormReserva').value = "POST";
            document.getElementById('tituloModalReserva').innerText = "Nova Reserva";
            document.getElementById('btnSalvarReserva').innerText = "Confirmar Reserva";
            document.getElementById('boxAlterarGrupo').style.display = "none";
            document.getElementById('boxDataLimite').style.display = "block";
            document.getElementById('boxDiasSemana').style.display = "block";
            // Limpa as caixas de seleção de dias
            form.querySelectorAll('input[name="dias_semana[]"]').forEach(el => el.checked = false);
        }

        function executarEdicaoReserva(id) {
            document.getElementById('modalErroContainer').classList.add('d-none');
            document.getElementById('tituloModalReserva').innerText = "A carregar dados...";
            
            fetch(`/reservas/${id}/edit`)
                .then(response => response.json())
                .then(reserva => {
                    document.getElementById('inputTitulo').value = reserva.titulo;
                    document.getElementById('inputResponsavel').value = reserva.responsavel_id;
                    document.getElementById('inputTipo').value = reserva.tipo;
                    document.getElementById('inputEspacoForm').value = reserva.espaco_id;
                    document.getElementById('inputDataReserva').value = reserva.data_reserva;
                    document.getElementById('inputHoraInicio').value = reserva.hora_inicio;
                    document.getElementById('inputHoraFim').value = reserva.hora_fim;
                    document.getElementById('inputEvento').value = reserva.evento_id || '';

                    const selectTipo = document.getElementById('inputTipo');
                    selectTipo.dispatchEvent(new Event('change'));

                    if (reserva.tipo === 'Fixa') {
                        document.getElementById('boxAlterarGrupo').style.display = "block";
                        document.getElementById('boxDataLimite').style.display = "none";
                        document.getElementById('boxDiasSemana').style.display = "none"; // Oculta a escolha de dias na edição simples
                    } else {
                        document.getElementById('boxAlterarGrupo').style.display = "none";
                    }

                    const form = document.getElementById('formReserva');
                    form.action = `/reservas/${id}`;
                    document.getElementById('metodoFormReserva').value = "PUT";
                    document.getElementById('tituloModalReserva').innerText = "Editar Reserva";
                    document.getElementById('btnSalvarReserva').innerText = "Atualizar Reserva";
                })
                .catch(err => console.error("Erro ao resgatar detalhes:", err));
        }

        async function submeterFormularioAssincrono(event) {
            event.preventDefault();
            const form = document.getElementById('formReserva');
            const url = form.action;
            const formData = new FormData(form);
            
            document.getElementById('btnSalvarReserva').innerText = "A processar...";
            document.getElementById('btnSalvarReserva').disabled = true;

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });

                const resultado = await response.json();

                if (response.ok && resultado.success) {
                    window.dispatchEvent(new CustomEvent('fechar-modal-formulario'));
                    window.recarregarCalendario();
                    
                    const toast = document.createElement('div');
                    toast.className = "alert alert-success position-fixed bottom-0 end-0 m-4 shadow-lg rounded-3 border-0";
                    toast.style.zIndex = "9999";
                    toast.innerHTML = `<i class="bi bi-check-circle-fill me-2"></i> ${resultado.message}`;
                    document.getElementById('containerAlertasGerais').appendChild(toast);
                    setTimeout(() => toast.remove(), 4000);
                } else {
                    document.getElementById('modalErroTexto').innerHTML = `<i class="bi bi-exclamation-octagon-fill me-2"></i> ${resultado.message || 'Erro de validação.'}`;
                    document.getElementById('modalErroContainer').classList.remove('d-none');
                }
            } catch (err) {
                console.error("Erro de requisição:", err);
            } finally {
                document.getElementById('btnSalvarReserva').disabled = false;
                document.getElementById('btnSalvarReserva').innerText = document.getElementById('metodoFormReserva').value === "PUT" ? "Atualizar Reserva" : "Confirmar Reserva";
            }
        }

        // LÓGICA DO MOTOR VISUAL CENTRALIZADA
        function inicializarMotorCalendario() {
            const SLOT_HEIGHT = 60;
            const START_HOUR = 8;

            window.recarregarCalendario = async function() {
                try {
                    const grid = document.querySelector('.calendar-grid');
                    if (!grid) return;

                    const colunas = grid.querySelectorAll('.day-col');
                    if (colunas.length === 0) return;
                    
                    const dataInicio = colunas[0].getAttribute('data-date');
                    const dataFim = colunas[colunas.length - 1].getAttribute('data-date');
                    const espacoId = document.getElementById('filtroEspaco').value;

                    // Limpa instâncias antigas da tela para re-renderização
                    document.querySelectorAll('.event-block').forEach(el => el.remove());

                    const response = await fetch(`/api/reservas-mensais?start=${dataInicio}&end=${dataFim}&espaco_id=${espacoId}`);
                    const reservas = await response.json();

                    reservas.forEach(reserva => {
                        const inicio = new Date(reserva.start);
                        const fim = new Date(reserva.end);

                        const dataFormatadaBanco = reserva.start.split('T')[0];
                        const coluna = grid.querySelector(`.day-col[data-date="${dataFormatadaBanco}"]`);
                        
                        if (!coluna) return;

                        const startH = inicio.getHours();
                        const startM = inicio.getMinutes();
                        const endH = fim.getHours();
                        const endM = fim.getMinutes();

                        const visualStartH = Math.max(startH, START_HOUR);
                        
                        // CORREÇÃO MATEMÁTICA: Adicionado o buffer fixo de 57px correspondente ao header
                        const top = ((visualStartH - START_HOUR + startM / 60) * SLOT_HEIGHT) + 57;
                        const height = Math.max((endH - visualStartH + (endM - startM) / 60) * SLOT_HEIGHT, 24);

                        const corClasse = {
                            'Oficial': 'event-oficial',
                            'Fixa':    'event-fixed',
                            'Avulsa':  'event-avulsa'
                        }[reserva.extendedProps.tipo] || 'event-avulsa';

                        const bloco = document.createElement('div');
                        bloco.className = `event-block ${corClasse}`;
                        bloco.style.top = top + 'px';
                        bloco.style.height = height + 'px';
                        
                        const horaInicioFormato = startH.toString().padStart(2,'0') + ':' + startM.toString().padStart(2,'0');
                        const horaFimFormato = endH.toString().padStart(2,'0') + ':' + endM.toString().padStart(2,'0');

                        // EXIBIÇÃO: Agora com horário de início e término na visualização compacta
                        bloco.innerHTML = `
                            <div class="event-title fw-bold text-truncate" style="font-size: 0.75rem;">${reserva.title}</div>
                            <div class="event-time" style="font-size: 0.62rem; margin-top: 1px; opacity: 0.9;"><i class="bi bi-clock"></i> ${horaInicioFormato} – ${horaFimFormato}</div>
                        `;

                        bloco.onclick = () => {
                            const arrayData = dataFormatadaBanco.split('-');
                            const dataBR = `${arrayData[2]}/${arrayData[1]}/${arrayData[0]}`;

                            window.dispatchEvent(new CustomEvent('abrir-modal-detalhes', {
                                detail: {
                                    id: reserva.id,
                                    title: reserva.extendedProps.titulo_puro,
                                    tipo: reserva.extendedProps.tipo,
                                    data: dataBR,
                                    horario: `${horaInicioFormato} às ${horaFimFormato}`,
                                    espaco: reserva.extendedProps.espaco_nome,
                                    responsavel: reserva.extendedProps.responsavel_nome,
                                    grupo_id: reserva.extendedProps.grupo_reserva_id
                                }
                            }));
                        };

                        coluna.appendChild(bloco);
                    });

                } catch (error) {
                    console.error('Erro de conexão ao carregar a agenda:', error);
                }
            };

            window.recarregarCalendario();
        }

        // SOLUÇÃO DO BUG DE REFRESH: Escuta o ciclo de vida tradicional E o do Hotwire Turbo!
        document.addEventListener('DOMContentLoaded', i => { if(!window.turboAtivo) inicializerFisico(); });
        document.addEventListener('turbo:load', () => { window.turboAtivo = true; inicializarMotorCalendario(); });
    </script>
</x-layouts.app>