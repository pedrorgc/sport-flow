<x-layouts.app>
    <main class="flex-grow-1" style="min-width: 0;" x-data="{ openModalInscricao: false, openModalLista: false, tipoInscricao: 'atleta' }"
        @open-modal-inscricao.window="openModalInscricao = true" @open-modal-lista.window="openModalLista = true"
        @close-modal-lista.window="openModalLista = false" @set-tipo.window="tipoInscricao = $event.detail">

        <div class="d-flex align-items-center justify-content-between mb-4 ps-5 ps-md-0 pt-2 pt-md-0">
            <h2 class="titulo-marca mb-0" style="font-size: 2.2rem;">Gestão de Inscrições</h2>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <x-stat-card title="Eventos Ativos" value="{{ $eventos->count() }}" subtitle="Para inscrições"
                    icon="bi bi-calendar2-check" color="primary" />
            </div>
        </div>

        @if ($errors->any())
            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
                <div id="toastErro" class="toast align-items-center text-bg-danger border-0 show" role="alert"
                    style="min-width: 420px; font-size: 16px; border-radius: 12px;">
                    <div class="d-flex">
                        <div class="toast-body">
                            @foreach ($errors->all() as $erro)
                                {{ $erro }}<br>
                            @endforeach
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto"
                            data-bs-dismiss="toast"></button>
                    </div>
                </div>
            </div>
            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toastErro');
                    if (toast) toast.classList.remove('show');
                }, 5000);
            </script>
        @endif

        <div class="card-premium mb-4 py-3 px-4">
            <form method="GET" action="{{ route('inscricoes.index') }}"
                class="d-flex flex-wrap gap-3 align-items-center">
                <div class="flex-grow-1" style="min-width:220px;">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i
                                class="bi bi-search"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control bg-light border-start-0 ps-0" placeholder="Buscar campeonato...">
                    </div>
                </div>
                <button type="submit" class="btn btn-premium d-flex align-items-center gap-2 shadow-sm">
                    <i class="bi bi-search"></i> Buscar
                </button>
                @if (request()->filled('search'))
                    <a href="{{ route('inscricoes.index') }}" class="btn btn-light text-danger shadow-sm"
                        title="Limpar">
                        <i class="bi bi-x-circle"></i> Limpar
                    </a>
                @endif
            </form>
        </div>

        <div class="card-premium p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase" style="letter-spacing: 0.5px;">
                            <th class="ps-4 py-3 border-bottom-0">Evento</th>
                            <th class="py-3 border-bottom-0">Modalidade</th>
                            <th class="py-3 border-bottom-0">Período de Inscrição</th>
                            <th class="py-3 border-bottom-0 text-center">Inscritos</th>
                            <th class="text-end pe-4 py-3 border-bottom-0">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($eventos as $evento)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="fw-semibold titulo-marca">{{ $evento->nome }}</div>
                                </td>
                                <td class="py-3 text-secondary">{{ $evento->modalidade->nome ?? '---' }}</td>
                                <td class="py-3 text-secondary small">
                                    {{ \Carbon\Carbon::parse($evento->inscricao_inicio)->format('d/m/Y') }} até
                                    {{ \Carbon\Carbon::parse($evento->inscricao_fim)->format('d/m/Y') }}
                                </td>
                                <td class="py-3 text-center">
                                    <span class="badge badge-soft-primary fw-medium px-2 py-1">
                                        {{ $evento->inscricoes_count }} registros
                                    </span>
                                </td>
                                <td class="text-end pe-4 py-3">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button type="button"
                                            class="btn btn-sm btn-light text-secondary hover-shadow fw-medium"
                                            title="Ver Inscritos"
                                            onclick="verInscritos({{ $evento->id }}, '{{ addslashes($evento->nome) }}')">
                                            <i class="bi bi-eye me-1"></i> Lista
                                        </button>

                                        <button type="button"
                                            class="btn btn-sm btn-premium hover-shadow fw-medium px-3"
                                            title="Inscrever Participante"
                                            onclick="abrirNovaInscricao({{ $evento->id }}, '{{ addslashes($evento->nome) }}')">
                                            <i class="bi bi-plus-lg me-1"></i> Inscrever
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-secondary py-5">Nenhum evento encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="openModalInscricao" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 2000;" x-transition.opacity
            @click.self="openModalInscricao = false">
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 600px;" x-show="openModalInscricao"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0" id="tituloModalInscricao">Lançar Inscrição</h4>
                        <button type="button"
                            class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 35px; height: 35px;" @click="openModalInscricao = false">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <form id="formInscricao" method="POST" action="{{ route('inscricoes.store') }}"
                        class="p-4">
                        @csrf
                        <input type="hidden" name="_method" id="metodoFormInscricao" value="POST">

                        <input type="hidden" name="evento_id" id="inputEventoId">

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-secondary">Evento Selecionado</label>
                            <input type="text" id="inputNomeEventoVisual"
                                class="form-control bg-light fw-bold text-primary" readonly>
                        </div>

                        <div class="mb-3 d-flex gap-4 p-3 bg-light rounded-3 border">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo" id="tipoAtleta"
                                    value="atleta" x-model="tipoInscricao">
                                <label class="form-check-label fw-medium" for="tipoAtleta">Atleta Individual</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipo" id="tipoTime"
                                    value="time" x-model="tipoInscricao">
                                <label class="form-check-label fw-medium" for="tipoTime">Equipe / Time</label>
                            </div>
                        </div>

                        <div class="mb-4" x-show="tipoInscricao === 'atleta'">
                            <label class="form-label fw-semibold small text-secondary">Selecionar Atleta <span
                                    class="text-danger">*</span></label>
                            <select name="atleta_id" id="inputAtleta" class="form-select bg-light">
                                <option value="">Escolha o atleta...</option>
                                @foreach ($atletas as $atleta)
                                    <option value="{{ $atleta->id }}">
                                        {{ $atleta->nome }} &nbsp;&nbsp;—&nbsp;&nbsp;
                                        ({{ $atleta->modalidade->nome ?? 'Sem Modalidade' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4" x-show="tipoInscricao === 'time'">
                            <label class="form-label fw-semibold small text-secondary">Selecionar Equipe <span
                                    class="text-danger">*</span></label>
                            <select name="time_id" id="inputTime" class="form-select bg-light">
                                <option value="">Escolha a equipe...</option>
                                @foreach ($times as $time)
                                    <option value="{{ $time->id }}">
                                        {{ $time->nome }} &nbsp;&nbsp;—&nbsp;&nbsp;
                                        ({{ $time->modalidade->nome ?? 'Sem Modalidade' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-secondary">Status da Inscrição <span
                                    class="text-danger">*</span></label>
                            <select name="status_inscricao" id="inputStatusInscricao" class="form-select bg-light"
                                required>
                                <option value="Confirmada">Confirmada</option>
                                <option value="Pendente">Pendente</option>
                                <option value="Cancelada">Cancelada</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                            <button type="button" class="btn btn-light fw-medium"
                                @click="openModalInscricao = false">Cancelar</button>
                            <button type="submit" id="btnSalvarInscricao" class="btn btn-premium px-4">Confirmar
                                Inscrição</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="openModalLista" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 2000;"
            @click.self="openModalLista = false" x-transition.opacity>
            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 650px;" x-show="openModalLista"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <div>
                            <h4 class="titulo-marca mb-0">Lista de Inscritos</h4>
                            <small class="text-secondary fw-bold text-primary" id="tituloVisualizarEvento"></small>
                        </div>
                        <button
                            class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 35px; height: 35px;" @click="openModalLista = false">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <div class="p-4" style="max-height: 450px; overflow-y: auto;">
                        <div id="listaInscritosEvento" class="d-flex flex-column gap-2">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end p-4 border-top">
                        <button type="button" class="btn btn-light px-4"
                            @click="openModalLista = false">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script>
        function abrirNovaInscricao(eventoId, eventoNome) {
            document.getElementById('formInscricao').reset();

            document.getElementById('inputEventoId').value = eventoId;
            document.getElementById('inputNomeEventoVisual').value = eventoNome;
            document.getElementById('inputStatusInscricao').value = "Confirmada";

            document.getElementById('formInscricao').action = "{{ route('inscricoes.store') }}";
            document.getElementById('metodoFormInscricao').value = "POST";
            document.getElementById('tituloModalInscricao').innerText = "Nova Inscrição";
            document.getElementById('btnSalvarInscricao').innerText = "Confirmar Inscrição";

            window.dispatchEvent(new CustomEvent('set-tipo', {
                detail: 'atleta'
            }));
            window.dispatchEvent(new CustomEvent('open-modal-inscricao'));
        }

        function abrirEdicaoInscricao(id) {
            window.dispatchEvent(new CustomEvent('close-modal-lista'));

            document.getElementById('tituloModalInscricao').innerText = "Carregando...";
            window.dispatchEvent(new CustomEvent('open-modal-inscricao'));

            fetch(`/inscricoes/${id}/edit`)
                .then(response => response.json())
                .then(dados => {
                    document.getElementById('inputEventoId').value = dados.evento_id;
                    document.getElementById('inputNomeEventoVisual').value = dados.evento.nome;
                    document.getElementById('inputStatusInscricao').value = dados.status_inscricao;

                    if (dados.time_id) {
                        window.dispatchEvent(new CustomEvent('set-tipo', {
                            detail: 'time'
                        }));
                        document.getElementById('inputTime').value = dados.time_id;
                        document.getElementById('inputAtleta').value = "";
                    } else {
                        window.dispatchEvent(new CustomEvent('set-tipo', {
                            detail: 'atleta'
                        }));
                        document.getElementById('inputAtleta').value = dados.atleta_id;
                        document.getElementById('inputTime').value = "";
                    }

                    document.getElementById('formInscricao').action = `/inscricoes/${id}`;
                    document.getElementById('metodoFormInscricao').value = "PUT";
                    document.getElementById('tituloModalInscricao').innerText = "Editar Inscrição";
                    document.getElementById('btnSalvarInscricao').innerText = "Atualizar Inscrição";
                })
                .catch(erro => {
                    console.error("Erro ao buscar dados da inscrição:", erro);
                    alert('Erro ao carregar dados da inscrição.');
                });
        }

        function verInscritos(eventoId, eventoNome) {
            const listaContainer = document.getElementById('listaInscritosEvento');
            document.getElementById('tituloVisualizarEvento').innerText = eventoNome;

            listaContainer.innerHTML =
                '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></div>';
            window.dispatchEvent(new CustomEvent('open-modal-lista'));

            fetch(`/inscricoes/${eventoId}`)
                .then(response => response.json())
                .then(dados => {
                    listaContainer.innerHTML = '';

                    if (dados.length > 0) {
                        dados.forEach(inscricao => {
                            let nomeParticipante = inscricao.atleta ? inscricao.atleta.nome : inscricao.time
                                .nome;
                            let tipoParticipante = inscricao.atleta ? 'Atleta Individual' : 'Equipe/Time';
                            let icone = inscricao.atleta ? 'bi-person' : 'bi-people';
                            let cor = inscricao.atleta ? 'primary' : 'success';
                            let statusCor = inscricao.status_inscricao === 'Confirmada' ? 'success' : (inscricao
                                .status_inscricao === 'Cancelada' ? 'danger' : 'warning');

                            listaContainer.innerHTML += `
                                <div class="d-flex align-items-center justify-content-between p-3 rounded-3 bg-light border border-opacity-10 hover-shadow transition">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-${cor} bg-opacity-10 text-${cor} rounded-circle d-flex align-items-center justify-content-center fs-5 shadow-sm" style="width: 45px; height: 45px;">
                                            <i class="bi ${icone}"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">${nomeParticipante}</div>
                                            <div class="text-secondary" style="font-size: 0.8rem;">
                                                ${tipoParticipante} • <span class="badge bg-${statusCor} bg-opacity-10 text-${statusCor} border border-${statusCor} border-opacity-25 ms-1">${inscricao.status_inscricao}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-sm btn-light text-primary hover-shadow" title="Editar Status" onclick="abrirEdicaoInscricao(${inscricao.id})">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        
                                        <button type="button" class="btn btn-sm btn-light text-danger hover-shadow" title="Cancelar Inscrição"
                                            onclick="window.dispatchEvent(new CustomEvent('confirmar-exclusao', { detail: { action: '/inscricoes/${inscricao.id}', mensagem: 'Cancelar a inscrição de ${nomeParticipante}?' } }))">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </div>
                            `;
                        });
                    } else {
                        listaContainer.innerHTML =
                            '<div class="text-center py-5 text-secondary"><i class="bi bi-inbox fs-1 mb-3 d-block opacity-50"></i> Nenhuma inscrição registrada para este evento ainda.</div>';
                    }
                })
                .catch(error => {
                    console.error("Erro ao buscar inscritos:", error);
                    listaContainer.innerHTML =
                        '<div class="text-center py-4 text-danger">Erro ao carregar a lista de inscritos.</div>';
                });
        }
    </script>
</x-layouts.app>
