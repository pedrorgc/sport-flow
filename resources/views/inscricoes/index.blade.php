<x-layouts.app>
    <div x-data="{ openModal: false, tipoInscricao: 'atleta' }" @open-modal-inscricao.window="openModal = true"
        @set-tipo.window="tipoInscricao = $event.detail" class="w-100">

        <div class="d-flex align-items-center justify-content-between mb-4 ps-5 ps-md-0 pt-2 pt-md-0">
            <div>
                <h2 class="titulo-marca mb-0" style="font-size: 2.2rem;">Inscrições</h2>
                <div class="text-secondary small mt-1">{{ $inscricoes->count() }} inscrições registradas</div>
            </div>
            <button type="button" class="btn btn-premium d-flex align-items-center gap-2 shadow-sm"
                onclick="abrirNovaInscricao()">
                <i class="bi bi-plus-lg"></i>
                <span class="d-none d-md-inline">Nova Inscrição</span>
            </button>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <x-stat-card title="Inscrições" value="{{ $inscricoes->count() }}" subtitle="Realizadas"
                    icon="bi bi-journal-check" color="secondary" />
            </div>
        </div>

        <div class="card-premium mb-4 py-3 px-4">
            <form method="GET" action="{{ route('inscricoes.index') }}"
                class="d-flex flex-wrap gap-3 align-items-center">

                <select name="evento_id" class="form-select bg-light shadow-sm" style="width:250px;">
                    <option value="">Todos os Eventos</option>
                    @foreach ($eventos as $ev)
                        <option value="{{ $ev->id }}" {{ request('evento_id') == $ev->id ? 'selected' : '' }}>
                            {{ $ev->nome }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-premium d-flex align-items-center gap-2 shadow-sm">
                    <i class="bi bi-funnel"></i> Filtrar
                </button>

                @if (request()->filled('evento_id'))
                    <a href="{{ route('inscricoes.index') }}"
                        class="btn btn-light text-danger d-flex align-items-center gap-2 shadow-sm"
                        title="Limpar Filtro">
                        <i class="bi bi-x-circle"></i> Limpar
                    </a>
                @endif
            </form>
        </div>

        @if ($errors->any())
            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">

                <div id="toastErro" class="toast align-items-center text-bg-danger border-0 show" role="alert"
                    style="min-width: 420px; font-size: 16px; border-radius: 12px;">

                    <div class="d-flex">
                        <div class="toast-body">
                            @foreach ($errors->all() as $erro)
                                {{ $erro }}
                            @endforeach
                        </div>

                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast">
                        </button>
                    </div>
                </div>
            </div>

            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toastErro');

                    if (toast) {
                        toast.classList.remove('show');
                    }
                }, 5000);
            </script>
        @endif

        <div class="card-premium p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-secondary small text-uppercase" style="letter-spacing: 0.5px;">
                            <th class="ps-4 py-3 border-bottom-0">Participante</th>
                            <th class="py-3 border-bottom-0">Evento</th>
                            <th class="py-3 border-bottom-0">Status</th>
                            <th class="py-3 border-bottom-0">Data da Inscrição</th>
                            <th class="text-end pe-4 py-3 border-bottom-0">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($inscricoes as $inscricao)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center gap-3">

                                        <!-- Lógica Visual: É um Atleta ou um Time? -->
                                        @if ($inscricao->atleta)
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold text-uppercase"
                                                style="width: 40px; height: 40px;">
                                                <i class="bi bi-person"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold titulo-marca">{{ $inscricao->atleta->nome }}
                                                </div>
                                                <div class="text-secondary small">Atleta Individual</div>
                                            </div>
                                        @elseif($inscricao->time)
                                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center fw-bold text-uppercase"
                                                style="width: 40px; height: 40px;">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold titulo-marca">{{ $inscricao->time->nome }}</div>
                                                <div class="text-secondary small">Equipe</div>
                                            </div>
                                        @endif

                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="fw-medium titulo-marca">{{ $inscricao->evento->nome }}</div>
                                    <div class="text-secondary small">
                                        {{ $inscricao->evento->modalidade->nome ?? 'Não informado' }}</div>
                                </td>
                                <td class="py-3">
                                    @php
                                        $corStatus = match ($inscricao->status_inscricao) {
                                            'Confirmada' => 'success',
                                            'Pendente' => 'warning',
                                            'Cancelada' => 'danger',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <span
                                        class="badge rounded-pill bg-{{ $corStatus }} bg-opacity-10 text-{{ $corStatus }} px-3 py-2 fw-medium border border-{{ $corStatus }} border-opacity-25">
                                        {{ $inscricao->status_inscricao }}
                                    </span>
                                </td>
                                <td class="py-3 text-secondary">
                                    <i class="bi bi-calendar3 me-2 text-primary opacity-75"></i>
                                    {{ \Carbon\Carbon::parse($inscricao->created_at)->format('d/m/Y') }}
                                </td>
                                <td class="text-end pe-4 py-3">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <button type="button" class="btn btn-sm btn-light text-primary hover-shadow"
                                            title="Editar Inscrição"
                                            onclick="abrirEdicaoInscricao({{ $inscricao->id }})">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="/inscricoes/{{ $inscricao->id }}" method="POST"
                                            onsubmit="return confirm('Tem certeza que deseja cancelar esta inscrição?');"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light text-danger hover-shadow"
                                                title="Cancelar Inscrição">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-secondary py-5">Nenhuma inscrição registrada
                                    no momento.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- MODAL DE INSCRIÇÃO -->
        <div x-show="openModal" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
            style="background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(2px); z-index: 2000;" x-transition.opacity
            @click.self="openModal = false">

            <div class="d-flex align-items-center justify-content-center w-100 h-100 p-3">
                <div class="bg-white rounded-4 shadow-lg w-100" style="max-width: 600px;" x-show="openModal"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="d-flex justify-content-between align-items-center p-4 border-bottom">
                        <h4 class="titulo-marca mb-0" id="tituloModalInscricao">Nova Inscrição</h4>
                        <button type="button"
                            class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center"
                            style="width: 35px; height: 35px;" @click="openModal = false">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <form id="formInscricao" method="POST" action="{{ route('inscricoes.store') }}"
                        class="p-4">
                        @csrf
                        <input type="hidden" name="_method" id="metodoFormInscricao" value="POST">

                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-secondary">Evento <span
                                    class="text-danger">*</span></label>
                            <select name="evento_id" id="inputEvento" class="form-select bg-light" required>
                                <option value="">Selecionar evento...</option>
                                @foreach ($eventos as $evento)
                                    <option value="{{ $evento->id }}">{{ $evento->nome }}
                                        ({{ $evento->modalidade->nome ?? 'Não informado' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- TOGGLE: ATLETA OU TIME -->
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

                        <!-- SELECT DO ATLETA (Aparece se tipo == 'atleta') -->
                        <div class="mb-4" x-show="tipoInscricao === 'atleta'">
                            <label class="form-label fw-semibold small text-secondary">Selecionar Atleta <span
                                    class="text-danger">*</span></label>
                            <select name="atleta_id" id="inputAtleta" class="form-select bg-light">
                                <option value="">Escolha o atleta...</option>
                                @foreach ($atletas as $atleta)
                                    <option value="{{ $atleta->id }}">{{ $atleta->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- SELECT DO TIME (Aparece se tipo == 'time') -->
                        <div class="mb-4" x-show="tipoInscricao === 'time'">
                            <label class="form-label fw-semibold small text-secondary">Selecionar Equipe <span
                                    class="text-danger">*</span></label>
                            <select name="time_id" id="inputTime" class="form-select bg-light">
                                <option value="">Escolha a equipe...</option>
                                @foreach ($times as $time)
                                    <option value="{{ $time->id }}">{{ $time->nome }}</option>
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
                                @click="openModal = false">Cancelar</button>
                            <button type="submit" id="btnSalvarInscricao" class="btn btn-premium px-4">Confirmar
                                Inscrição</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- SCRIPT DE GERENCIAMENTO (CREATE E EDIT) -->
    <script>
        const formInscricao = document.getElementById('formInscricao');
        const metodoFormInscricao = document.getElementById('metodoFormInscricao');
        const tituloModalInscricao = document.getElementById('tituloModalInscricao');
        const btnSalvarInscricao = document.getElementById('btnSalvarInscricao');

        function abrirNovaInscricao() {
            formInscricao.reset();
            formInscricao.action = "{{ route('inscricoes.store') }}";
            metodoFormInscricao.value = "POST";
            tituloModalInscricao.innerText = "Nova Inscrição";
            btnSalvarInscricao.innerText = "Confirmar Inscrição";

            // Dispara um evento limpo para o Alpine voltar para a aba 'atleta'
            window.dispatchEvent(new CustomEvent('set-tipo', {
                detail: 'atleta'
            }));

            window.dispatchEvent(new CustomEvent('open-modal-inscricao'));
        }

        function abrirEdicaoInscricao(id) {
            tituloModalInscricao.innerText = "Carregando...";
            window.dispatchEvent(new CustomEvent('open-modal-inscricao'));

            fetch(`/inscricoes/${id}/edit`)
                .then(response => response.json())
                .then(dados => {
                    document.getElementById('inputEvento').value = dados.evento_id;
                    document.getElementById('inputStatusInscricao').value = dados.status_inscricao;

                    // Dispara o evento avisando o Alpine qual aba abrir e preenche os dados
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

                    formInscricao.action = `/inscricoes/${id}`;
                    metodoFormInscricao.value = "PUT";
                    tituloModalInscricao.innerText = "Editar Inscrição";
                    btnSalvarInscricao.innerText = "Atualizar Inscrição";
                })
                .catch(erro => console.error("Erro ao buscar dados da inscrição:", erro));
        }
    </script>
</x-layouts.app>
